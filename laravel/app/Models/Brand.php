<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(string $string, int $int)
 */
class Brand extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    protected $guarded = [];

    public function product(): BelongsToMany
    {
        return  $this->belongsToMany(Product::class);
    }

    public function brand_product()
    {
        return  $this->belongsToMany(Product::class);
    }

    public function limited_product(): BelongsToMany
    {
        return  $this->belongsToMany(Product::class)->orderBy('order_by', 'asc')->limit(1);
    }

    public function product_count()
    {
        return $this->belongsToMany(Product::class)->count();
    }

    public function like()
    {
        return $this->hasOne(BrandLike::class)->where('is_liked', 1);
    }
}
