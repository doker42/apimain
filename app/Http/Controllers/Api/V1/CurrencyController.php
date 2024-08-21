<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRateRequest;
use App\Http\Resources\V1\CurrencyCollection;
use App\Http\Resources\V1\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function rates()
    {
        $per_page = 5;
        $source = \App\Currencies\CurrencyManager::getSource();
        $currencies = Currency::where('currency_sources_id', $source->getId())->paginate($per_page);
//        return new CurrencyCollection($currencies);
        return CurrencyResource::collection($currencies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function rate(CurrencyRateRequest $request)
    {
//        dd($request->except('__token'));
        $validated = $request->validated();

        $currency = Currency::find($validated['currency_id']);

        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
