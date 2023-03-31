<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static latest()
 * @method static where(string $string, string $track_number)
 * @method static create(array $order_data)
 * @method static whereIn(string $string, array|int[] $status_id)
 * @method static whereBetween(string $string, array $array)
 * @method static whereDate(string $string, mixed $input)
 * @method static whereMonth(string $string, string $date)
 * @method static whereHas(string $string, \Closure $param)
 * @method static orderBy(string $string, string $string1)
 * @method static select(string $string)
 */
class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id', 'id');
    }

    public function delivery_charge(): HasOne
    {
        return $this->hasOne(OrderDeliveryCharge::class);
    }

    public function order_product(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function shipping_status(): BelongsTo
    {
        return $this->belongsTo(ShippingStatus::class);
    }
    public function payment_status(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class);
    }
    public function global_order_product(): HasOne
    {
        return $this->hasOne(OrderProduct::class);
    }
    public function transaction(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)->latest()->withTimestamps();
    }

}
