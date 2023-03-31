<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $status_data)
 * @method static where(string $string, $order_number)
 */
class OrderStatusDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shipping_status()
    {
        return $this->belongsTo(ShippingStatus::class);
    }
}
