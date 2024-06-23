<?php

namespace App\Models;

use App\DTO\ExchangeDTO;
use PDO;

class CurrencyModel extends Model
{
    public function getCurrencies(): array
    {
        $sth = $this->database->prepare("SELECT * FROM currencies");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveCurrencies(array $currencies): array
    {
        foreach ($currencies as $currency) {
            $stmt = $this->database->prepare("INSERT INTO currencies (name, abbreviation) VALUES (:name, :abbreviation)");
            $stmt->bindParam('name', $currency['Cur_Name']);
            $stmt->bindParam('abbreviation', $currency['Cur_Abbreviation']);
            $stmt->execute();
        }

        return $this->getCurrencies();
    }

    public function getAllExchanges(): array
    {
        $sth = $this->database->prepare("SELECT * FROM exchange_rates");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExchangesByDate(string $date): array
    {
        $sth = $this->database->prepare("SELECT * FROM exchange_rates WHERE date = :date");
        $date = $this->convertDate($date);
        $sth->bindParam('date', $date);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveDailyExchange(ExchangeDTO $exchange): bool
    {
        $stmt = $this->database->prepare("INSERT INTO exchange_rates (target_currency_id, date, rate) VALUES (:target_currency_id, :date, :rate)");
        $stmt->bindParam('target_currency_id', $exchange->targetCurrencyId);
        $stmt->bindParam('date', $exchange->date);
        $stmt->bindParam('rate', $exchange->rate);

        return $stmt->execute();
    }

    public function getCurrencyIdByAbbreviation(string $abbreviation): int
    {
        $sth = $this->database->prepare("SELECT id FROM currencies WHERE abbreviation = :abbreviation");
        $sth->bindParam('abbreviation', $abbreviation);
        $sth->execute();

        $currency = $sth->fetch(PDO::FETCH_ASSOC);

        if (empty($currency)) {
            throw new \Exception("No currency found in database, try to call '/getCurrencies'");
        }

        return $currency['id'];
    }

    private function convertDate(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }
}