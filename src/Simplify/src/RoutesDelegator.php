<?php

namespace Fintech\Simplify;

use Fintech\Simplify\Handler\TransactionCreateHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var $app Application */
        $app = $callback();

        $app->post('/api/transactions', TransactionCreateHandler::class, 'transactions.post');

        return $app;
    }
}
