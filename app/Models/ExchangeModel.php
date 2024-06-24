<?php

namespace App\Models;

use App\DTO\ExchangeDTO;
use PDO;

class ExchangeModel extends Model
{
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

    private function convertDate(string $date): string
    {
        return date('Y-m-d', strtotime($date));
    }
}