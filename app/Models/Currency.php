<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 *
 * @property string $name
 * @property string $slug
 * @property float $rate
 */
class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'rate',
        'currency_sources_id'
    ];


}
