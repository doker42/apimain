<?php

namespace App\Currencies;

use App\Exceptions\SourceAbsentException;
use App\Models\CurrencySource;

class CurrencyManager
{
    /**
     * @param int|null $sourceId
     * @return FreaksCurrency|FreeCurrency|null
     * @throws SourceAbsentException
     */
    public static function getSource(int|null $sourceId = null): FreaksCurrency|FreeCurrency|null
    {
        $source = null;

        if ($sourceId) {
            $source = CurrencySource::class::where('id', $sourceId)->first();
        }

        if (!$source) {
            $source = self::getActualSource();

            return self::getCurrencySource($source->slug);

        } else {
            throw new SourceAbsentException();
        }
    }


    public static function getDefaultSource(): mixed
    {
        return CurrencySource::class::where('default', true)->first();
    }


    public static function getActiveSource(): mixed
    {
        return CurrencySource::class::where('active', true)->first();
    }


    public static function getActualSource(): mixed
    {
        return self::getActiveSource() ?: self::getDefaultSource();
    }


    public static function getCurrencySource(string $slug)
    {
        return match($slug) {
            FreaksCurrency::FREAKS_SLUG => new FreaksCurrency(),
            FreeCurrency::FREE_SLUG     => new FreeCurrency(),
            default => null
        };
    }


}
