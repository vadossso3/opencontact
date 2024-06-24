<?php

use App\Controllers\CurrencyController;
use App\Controllers\ExchangeController;
use App\Controllers\MainController;

return [
    '/' => ['name' => 'index', 'controller' => MainController::class, 'method' => 'GET', 'arguments' => []],
    '/getAll' => ['name' => 'getAll', 'controller' => ExchangeController::class, 'method' => 'GET', 'arguments' => []],
    '/getByDate' => ['name' => 'getByDate', 'controller' => ExchangeController::class, 'method' => 'GET', 'arguments' => ['date']],
    '/getCurrencies' => ['name' => 'getCurrencies', 'controller' => ExchangeController::class, 'method' => 'GET', 'arguments' => []],
    '/getDailyExchanges' => ['name' => 'getDailyExchanges', 'controller' => CurrencyController::class, 'method' => 'GET', 'arguments' => []],
];
