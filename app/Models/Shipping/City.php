<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($city_data)
 * @method static where(string $string, int $int)
 */
class City extends Model
{
    use HasFactory;
    protected $guarded = [];
}
