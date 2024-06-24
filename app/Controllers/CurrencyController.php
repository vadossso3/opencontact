<?php

namespace App\Controllers;

use App\Services\CurrencyService;

class CurrencyController
{
    private CurrencyService $currencyService;

    public function __construct()
    {
        $this->currencyService = new CurrencyService();
    }

    public function getCurrencies(): array
    {
        return $this->currencyService->getCurrencies();
    }
}