<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $product_data)
 * @method static findOrFail($product_id)
 * @method static select(string $string)
 */
class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
}
