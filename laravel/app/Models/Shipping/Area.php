<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($area_data)
 * @method static where(string $string, int $id)
 */
class Area extends Model
{
    use HasFactory;
    protected $guarded = [];
}
