<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(string $string, $category_id)
 * @method static whereHas(string $string, \Closure $param)
 * @method static select(string $string, string $string1, string $string2)
 * @method static whereIn(string $string, $my_order_products)
 * @method static doesntHave(string $string)
 * @method static inRandomOrder()
 */
class Product extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $guarded = [];

    public function product_photo(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function product_photos_without_primary(): HasMany
    {
        return $this->product_photo()->where('primary', null);
    }

    public function seo(): HasOne
    {
        return $this->hasOne(SEO::class);
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tag(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function brand(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc');
    }

    public function faq(): HasMany
    {
        return $this->hasMany(ProductFAQ::class);
    }

    public function productVariations(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function delivery_information(): HasOne
    {
        return $this->hasOne(ProductDeliveryInformation::class);
    }

    public function product_specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function primary_photo(): HasOne
    {
        return $this->hasOne(ProductPhoto::class)->where('primary', 1);
    }

    public function video(): HasOne
    {
        return $this->hasOne(ProductVideo::class);
    }

    public function parent_product(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent', 'id');
    }

    public function product_own_variations(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'child_product_id');
    }

    public function grocery_product(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function productOrderCount(): HasOne
    {
        return $this->hasOne(ProductOrderCount::class);
    }

    public function bestSellingProduct(): HasOne
    {
        return $this->hasOne(ProductOrderCount::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'product_origin');
    }

    public function my_review(): HasMany
    {
        return $this->hasMany(Review::class)->where('customer_id' , auth()->user()->id);
    }

    public function child_product(): HasMany
    {
        return $this->hasMany(Product::class, 'parent', 'id')->select('id', 'price', 'parent');
    }

    public function child_product_filter(): HasMany
    {
        return $this->hasMany(Product::class, 'parent', 'id');
    }

}
