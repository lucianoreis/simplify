<?php

declare(strict_types=1);

namespace Fintech\Simplify\Service;

use Doctrine\ORM\EntityManager;
use Fintech\Simplify\Entity\User;

class UserService
{
    protected EntityManager $em;
    protected $entity = User::class;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data): array
    {
    }
}
