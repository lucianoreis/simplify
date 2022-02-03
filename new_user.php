<?php

declare(strict_types=1);

require 'vendor/autoload.php';
$container = require 'config/container.php';

$service = $container->get(\Fintech\Simplify\Service\UserService::class);

$data = [
    'name' => $argv[1],
    'cpf_cnpj' => $argv[2],
    'email' => $argv[3],
    'password' => $argv[4],
    'provider' => $argv[5],
    'balance' => $argv[6],
];
$user = $service->addUser($data);

print_r($user);

# php new_user.php Luciano 11111111 luciano@teste.com 123 false 500.60
