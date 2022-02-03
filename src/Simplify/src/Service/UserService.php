<?php

declare(strict_types=1);

namespace Fintech\Simplify\Service;

use Doctrine\ORM\EntityManager;
use Fintech\Simplify\Entity\User;
use Laminas\Hydrator\ClassMethodsHydrator;

class UserService
{
    protected EntityManager $em;
    protected $entity = User::class;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addUser(array $data): array
    {
        $this->em->getConnection()->beginTransaction();
        try {
            $entity = new $this->entity();

            $classMethods = new ClassMethodsHydrator();
            $classMethods->hydrate($data, $entity);

            $this->em->persist($entity);
            $this->em->flush();
            $this->em->getConnection()->commit();

            return $entity->toArray();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            return [$e->getMessage()];
        }
    }
}
