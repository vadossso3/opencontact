<?php

namespace App\Services;

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
}