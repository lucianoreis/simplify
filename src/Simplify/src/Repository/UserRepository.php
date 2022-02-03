<?php

declare(strict_types=1);

namespace Fintech\Simplify\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getAll(): array
    {
        try {
            $data = $this->findAll();
            $dataArray = [];

            foreach ($data as $object) {
                $dataArray[] = $object->toArray();
            }

            return $dataArray;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getOne(int $id): array
    {
        try {
            $entity = $this->findOneBy(['id' => $id]);
            return !empty($entity) ? $entity->toArray() : [];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
