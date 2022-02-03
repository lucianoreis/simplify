<?php

declare(strict_types=1);

namespace Fintech\Simplify;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Application;

/**
 * The configuration provider for the Fintech\Simplify\Simplify module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'input_filters' => $this->getInputFilters()
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'invokables' => [
            ],
            'factories'  => [
                Handler\TransactionCreateHandler::class => Handler\TransactionCreateHandlerFactory::class,
                Service\TransactionService::class => Service\TransactionServiceFactory::class,
                Service\UserService::class => Service\UserServiceFactory::class
            ],
        ];
    }

    public function getInputFilters() : array
    {
        return [
            'factories' => [
                InputFilter\TransactionInputFilter::class => InvokableFactory::class,
            ],
        ];
    }
}
