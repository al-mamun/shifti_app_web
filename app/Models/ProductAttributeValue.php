<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(\any[] $all)
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail(int $id)
 * @method static where(string $string, $id)
 * @method static select(string $string, string $string1, string $string2)
 */
class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attribute_name(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }
}
