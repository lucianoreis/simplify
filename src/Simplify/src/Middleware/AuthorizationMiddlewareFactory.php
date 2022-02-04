<?php

declare(strict_types=1);

namespace Fintech\Simplify\Middleware;

use Psr\Container\ContainerInterface;

class AuthorizationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : AuthorizationMiddleware
    {
        $urlAuthorizationService = $container->get('config')['url_authorization_service'];

        return new AuthorizationMiddleware($urlAuthorizationService);
    }
}
