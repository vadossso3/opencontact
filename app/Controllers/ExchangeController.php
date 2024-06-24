<?php

namespace App\Controllers;

use App\Services\ExchangeService;

class ExchangeController
{
    private ExchangeService $exchangeService;

    public function __construct()
    {
        $this->exchangeService = new ExchangeService();
    }

    public function getDailyExchanges(): bool
    {
        return $this->exchangeService->getDailyExchanges();
    }

    public function getAll(): array
    {
        return $this->exchangeService->getAllExchanges();
    }

    public function getByDate(string $date)
    {
        return $this->exchangeService->getExchangesByDate($date);
    }
}