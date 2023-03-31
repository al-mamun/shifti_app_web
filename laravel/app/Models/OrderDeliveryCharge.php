<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $delivery_charge_data)
 */
class OrderDeliveryCharge extends Model
{
    use HasFactory;

    protected $guarded = [];
}
