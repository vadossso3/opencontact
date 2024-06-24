<?php

namespace App\DTO;

class ExchangeDTO
{
    public function __construct(
        public int $targetCurrencyId,
        public string $date,
        public float $rate,
    )
    {}
}