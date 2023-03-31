<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($zone_data)
 * @method static where(string $string, int $int)
 */
class Zone extends Model
{
    use HasFactory;
    protected $guarded = [];
}
