<?php

namespace App\Services;

use App\DTO\ExchangeDTO;
use App\Models\CurrencyModel;
use App\Models\ExchangeModel;

class ExchangeService
{
    private ExchangeModel $exchangeModel;
    private CurrencyModel $currencyModel;

    public function __construct()
    {
        $this->exchangeModel = new ExchangeModel();
        $this->currencyModel = new CurrencyModel();
    }

    public function getDailyExchanges(): bool
    {
        $rawExchanges = file_get_contents("https://api.nbrb.by/exrates/rates?periodicity=0");

        $exchanges = json_decode($rawExchanges, true);

        foreach ($exchanges as $exchange) {
            $currencyId = $this->currencyModel->getCurrencyIdByAbbreviation($exchange['Cur_Abbreviation']);

            $exchange = new ExchangeDTO($currencyId, $exchange['Date'], floatval($exchange['Cur_OfficialRate']));

            $this->exchangeModel->saveDailyExchange($exchange);
        }

        return true;
    }

    public function getAllExchanges(): array
    {
        return $this->exchangeModel->getAllExchanges();
    }

    public function getExchangesByDate(string $date): array
    {
        return $this->exchangeModel->getExchangesByDate($date);
    }
}