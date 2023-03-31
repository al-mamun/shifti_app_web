<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $all)
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 * @method static where(string $string, int $id)
 */
class ProductAttribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attribute_value(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
