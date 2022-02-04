<?php

declare(strict_types=1);

namespace Fintech\Simplify\Middleware;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizationMiddleware implements MiddlewareInterface
{
    private $urlAuthorizationService;

    public function __construct($urlAuthorizationService)
    {
        $this->urlAuthorizationService =$urlAuthorizationService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $curl = curl_init($this->urlAuthorizationService);
        curl_setopt($curl, CURLOPT_URL, $this->urlAuthorizationService);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if ($response->message !== 'Autorizado') {
            return new JsonResponse(['message' => 'Unauthorized'], 401);
        }

        return $handler->handle($request);
    }
}
