<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencySource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'default',
        'active',
        'currency_source_id',
        'base_url',
        'api_key',
    ];


}
