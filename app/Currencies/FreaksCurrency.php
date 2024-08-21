<?php

namespace App\Currencies;

use App\Exceptions\SourceAbsentException;
use App\Models\CurrencySource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

final class FreaksCurrency extends AbstractCurrency implements CurrencyInterface
{

    private object|null $source;

    public const FREAKS_SLUG = 'freaks';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->source = CurrencySource::where('slug', self::FREAKS_SLUG)->first();
    }


    /**
     *
     * @throws SourceAbsentException
     *
     * @return mixed
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function rates(): mixed
    {
        if (!$this->source) {
            throw new SourceAbsentException();
        }

        $url = $this->source->base_url . '/rates/latest?apikey=' . $this->source->api_key;

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->get($url);
        $rates = json_decode($response->body(), true);

        return $this->ratesAdapt($rates);
    }


    private function ratesAdapt(array $rates): array
    {
        $res = [];
        if (!count($rates) || (isset($rates['rates']) && !count($rates['rates']))) {
            return $res;
        }

        foreach($rates['rates'] as $key => $rate) {
            $res[] = [
                'name' => $key,
                'slug' => $key,
                'rate' => $rate,
                'currency_sources_id' => $this->source->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
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
