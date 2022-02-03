<?php

declare(strict_types=1);

namespace Fintech\Simplify\Service;

use Fintech\Simplify\InputFilter\TransactionInputFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;

class TransactionServiceFactory
{
    public function __invoke(ContainerInterface $container): TransactionService
    {
        $em = $container->get('doctrine.entity_manager.orm_default');
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(TransactionInputFilter::class);

        return new TransactionService($em, $inputFilter);
    }
}
