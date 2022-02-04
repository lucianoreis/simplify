<?php

namespace Fintech\Simplify\Service;

use Doctrine\ORM\EntityManager;
use Fintech\Simplify\Entity\Transaction;
use Fintech\Simplify\Exception\ValidatorErrorExeption;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\InputFilter\InputFilterInterface;

class TransactionService
{
    protected EntityManager $em;
    private InputFilterInterface $inputFilter;
    protected $entity = Transaction::class;

    public function __construct(EntityManager $em, InputFilterInterface $inputFilter)
    {
        $this->em = $em;
        $this->inputFilter = $inputFilter;

    }

    public function transfer(array $parsedBody)
    {
        $this->inputFilter->setData($parsedBody);
        if (!$this->inputFilter->isValid()) {
            foreach ($this->inputFilter->getMessages() as $field => $error) {
                foreach ($error as $k => $v) {
                    throw new ValidatorErrorExeption('Unprocessable Entity', 'Failed Validation', "$field - $v", 422);
                }
            }
        }
        $data = $this->inputFilter->getValues();

        $this->em->getConnection()->beginTransaction();
        try {
            $entity = new $this->entity();

            $payer = $this->em
                ->getRepository('Fintech\Simplify\Entity\User')
                ->find($data['payer']);

            $payee = $this->em
                ->getRepository('Fintech\Simplify\Entity\User')
                ->find($data['payee']);

            $amount = $data['amount'];

            if ($payer->getProvider()) {
                throw new ValidatorErrorExeption('Unprocessable Entity', 'Suppliers do not make transfers', 'This operation can only be done between users.', 403);
            }

            if ($payer->getBalance() < $amount) {
                throw new ValidatorErrorExeption('Unprocessable Entity', 'Insufficient funds', 'Balance must be greater than or equal to the transfer amount.', 403);
            }

            $row = [
               'payer' => $payer,
               'payee' => $payee,
               'amount' => $amount,
               'description' => $data['description'] ?? ''
            ];

            $classMethods = new ClassMethodsHydrator();
            $classMethods->hydrate($row, $entity);

            $this->em->persist($entity);

            $payerFutureBalance = $payer->getBalance() - $amount;
            $payeeFutureBalance = $payee->getBalance() + $amount;

            $payer->setBalance($payerFutureBalance);
            $payee->setBalance($payeeFutureBalance);

            $this->em->persist($payer);
            $this->em->persist($payee);

            $this->em->flush();

            $this->em->getConnection()->commit();

            $response = $entity->toArray();
            $response['payer'] = $payer->getId();
            $response['payee'] = $payee->getId();

            return $response;
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            return $e->toArray();
        }
    }

    public function getOne(int $id): array
    {
        try {
            $repository = $this->em->getRepository($this->entity);
            return $repository->getOne($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
