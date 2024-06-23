<?php

// list of routes

use App\Controllers\CurrencyController;

return [
    '/getAll' => ['name' => 'getAll', 'controller' => CurrencyController::class, 'method' => 'GET', 'arguments' => []],
    '/getByDate' => ['name' => 'getByDate', 'controller' => CurrencyController::class, 'method' => 'GET', 'arguments' => ['date']],
    '/getCurrencies' => ['name' => 'getCurrencies', 'controller' => CurrencyController::class, 'method' => 'GET', 'arguments' => []],
    '/getDailyExchanges' => ['name' => 'getDailyExchanges', 'controller' => CurrencyController::class, 'method' => 'GET', 'arguments' => []],
];
