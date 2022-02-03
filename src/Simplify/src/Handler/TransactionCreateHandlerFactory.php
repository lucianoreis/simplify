<?php

declare(strict_types=1);

namespace Fintech\Simplify\Handler;

use Fintech\Simplify\Service\TransactionService;
use Psr\Container\ContainerInterface;

class TransactionCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TransactionCreateHandler
    {
        $service = $container->get(TransactionService::class);
        return new TransactionCreateHandler($service);
    }
}
