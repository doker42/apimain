<?php

namespace App\Currencies;

use App\Exceptions\SourceAbsentException;
use App\Models\CurrencySource;
use Illuminate\Support\Facades\Http;

final class FreeCurrency extends AbstractCurrency implements CurrencyInterface
{
    private object|null $source;

    public const FREE_SLUG = 'free';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->source = CurrencySource::where('slug', self::FREE_SLUG)->first();
    }


    /**
     * @return mixed
     * @throws SourceAbsentException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function rates(): mixed
    {
        if (!$this->source) {
            throw new SourceAbsentException();
        }

        $url = $this->source->base_url . '?apikey=' . $this->source->api_key;
        $response = Http::withHeaders(['Content-Type' => 'application/json'])->get($url);
        $rates = json_decode($response->body(), true);

        return $this->ratesAdapt($rates);
    }


    private function ratesAdapt(array $rates): array
    {
        $res = [];
        if (!count($rates) || (isset($rates['data']) && !count($rates['data']))) {
            return $res;
        }

        foreach($rates['data'] as $key => $rate) {
            $res[] = [
                'name' => $key,
                'slug' => $rate['code'],
                'rate' => $rate['value'],
                'currency_sources_id' => $this->source->id
            ];
        }

        return $res;
    }

    public function rate(string $currency)
    {
        //
    }


    public function getId()
    {
        return $this->source->id;
    }
}
