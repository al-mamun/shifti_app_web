<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, $id)
 * @method static findOrFail(int $id)
 * @method static create(array $cart)
 * @method static whereIn(string $string, int[] $array)
 */
class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cartVariation(): HasMany
    {
        return $this->hasMany(CartVariation::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
