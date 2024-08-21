<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrenciesUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:currency-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start');

        $source = \App\Currencies\CurrencyManager::getSource();

        DB::beginTransaction();

        try {

            $currenciesRates = $source->rates();

            DB::table('currencies')->truncate();

//            Currency::where('currency_sources_id', $source->getId())->delete();

            DB::table('currencies')->insert($currenciesRates);

            DB::commit();

            $this->info('Success');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Error update currencies: ' . $e->getMessage());

            $this->info('Error occured');
        }

    }
}
