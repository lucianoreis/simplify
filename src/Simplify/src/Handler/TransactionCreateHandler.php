<?php

declare(strict_types=1);

namespace Fintech\Simplify\Handler;

use Fintech\Simplify\Service\TransactionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TransactionCreateHandler implements RequestHandlerInterface
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = $request->getParsedBody();
        return $this->service->transfer($data);
    }
}
