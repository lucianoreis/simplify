<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = require 'config/container.php';

return new HelperSet([
   'em' => new EntityManagerHelper($container->get('doctrine.entity_manager.orm_default'))
]);
