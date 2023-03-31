<?php

namespace App\Models\Delivery;

use App\Models\Shipping\Area;
use App\Models\Shipping\City;
use App\Models\Shipping\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $delivery_zone)
 * @method static findOrFail(mixed $delivery_zone_id)
 */
class DeliveryZone extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function area(): BelongsToMany
    {
        return $this->belongsToMany(Area::class);
    }
}
