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

    public function getDailyExchanges(): bool
    {
        return $this->currencyService->getDailyExchanges();
    }

    public function getAll(): array
    {
        return $this->currencyService->getAllExchanges();
    }

    public function getByDate(string $date)
    {
        return $this->currencyService->getExchangesByDate($date);
    }

    public function getCurrencies(): array
    {
        return $this->currencyService->getCurrencies();
    }
}