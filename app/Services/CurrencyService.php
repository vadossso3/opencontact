<?php

namespace App\Services;

use App\DTO\ExchangeDTO;
use App\Models\CurrencyModel;

class CurrencyService
{
    private CurrencyModel $currencyModel;

    public function __construct()
    {
        $this->currencyModel = new CurrencyModel();
    }

    public function getCurrencies(): array
    {
        $currencies = $this->currencyModel->getCurrencies();

        if (empty($currencies)) {
            $rawCurrencies = file_get_contents("https://api.nbrb.by/exrates/rates?periodicity=0");

            $currencies = $this->currencyModel->saveCurrencies(json_decode($rawCurrencies, true));
        }

        return $currencies;
    }

    public function getDailyExchanges(): bool
    {
        $rawExchanges = file_get_contents("https://api.nbrb.by/exrates/rates?periodicity=0");

        $exchanges = json_decode($rawExchanges, true);

        foreach ($exchanges as $exchange) {
            $currencyId = $this->currencyModel->getCurrencyIdByAbbreviation($exchange['Cur_Abbreviation']);

            $exchange = new ExchangeDTO($currencyId, $exchange['Date'], floatval($exchange['Cur_OfficialRate']));

            $this->currencyModel->saveDailyExchange($exchange);
        }

        return true;
    }

    public function getAllExchanges(): array
    {
        return $this->currencyModel->getAllExchanges();
    }

    public function getExchangesByDate(string $date): array
    {
        return $this->currencyModel->getExchangesByDate($date);
    }
}