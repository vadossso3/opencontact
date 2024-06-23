<?php

use App\Router\Router;

include_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$router = (new Router());

print_r($router->run());


