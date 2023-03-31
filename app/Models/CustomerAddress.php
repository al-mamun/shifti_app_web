<?php

namespace App\Models;

use App\Models\Shipping\Area;
use App\Models\Shipping\City;
use App\Models\Shipping\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(string $string, $id)
 */
class CustomerAddress extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
  
}
