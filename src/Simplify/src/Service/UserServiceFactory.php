<?php

declare(strict_types=1);

namespace Fintech\Simplify\Service;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        $em = $container->get(EntityManager::class);
        return new UserService($em);
    }
}
