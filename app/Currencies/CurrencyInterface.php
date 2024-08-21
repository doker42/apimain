<?php

namespace App\Currencies;

interface CurrencyInterface
{
    public function rates();

    public function rate(string $currency);

}
