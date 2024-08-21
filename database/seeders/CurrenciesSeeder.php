<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencySources = [
            [
                'name'     => 'FreeCurrencies',
                'slug'     => 'free',
                'description' => 'FreeCurrencies description',
                'default'  => false,
                'active'   => false,
                'base_url' => 'https://api.currencyapi.com/v3/latest',
                'api_key'  => 'fca_live_n4r4oLOruKB426bC3UXpinIOEF7jQWpQ7nM358ad',
            ],
            [
                'name'     => 'FreaksCurrencies',
                'slug'     => 'freaks',
                'description' => 'FreaksCurrencies description',
                'default'  => 1,
                'active'   => true,
                'base_url' => 'https://api.currencyfreaks.com/v2.0',
                'api_key'  => 'f115da5e5ef341d1bb662b9c7d7005fa',
            ],
        ];

        DB::table('currency_sources')->insert($currencySources);
    }
}
