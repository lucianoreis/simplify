<?php

namespace Fintech\Simplify\Service;

use Doctrine\ORM\EntityManager;
use Fintech\Simplify\Entity\Transaction;
use Fintech\Simplify\Entity\User;
use Laminas\Diactoros\Response\JsonResponse;
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

    public function transfer(array $parsedBody): JsonResponse
    {
        $this->inputFilter->setData($parsedBody);
        if (!$this->inputFilter->isValid()) {
            return new JsonResponse(
                [
                    "detail" => "Failed Validation",
                    "status" => 422,
                    "title" => "Unprocessable Entity",
                    "validation_messages" => $this->inputFilter->getMessages(),
                ],
                422
            );

        }
        $data = $this->inputFilter->getValues();

        try {
            # NÃO ESQUECER DE POR UMA TRANSAÇÃO
            $entity = new $this->entity();

            $payer = $this->em->getReference(User::class, $data['payer']);
            $payee = $this->em->getReference(User::class, $data['payee']);
            $amount = $data['amount'];

            $row = [
               'payer' => $payer,
               'payee' => $payee,
               'amount' => $amount,
               'description' => $data['description']
            ];

            $classMethods = new ClassMethodsHydrator();
            $classMethods->hydrate($row, $entity);

            $this->em->persist($entity);
            $this->em->flush();

            return new JsonResponse($entity->toArray(), 201);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 422);
        }
    }
}
