<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * @method static create(array $all)
 * @method static findOrFail(int $id)
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, $null)
 * @method static whereNotNull(string $string)
 * @method static select(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9)
 * @method static whereIn(string $string, int[] $array)
 * @property mixed category_name
 */
class Category extends Model
{
    use HasFactory, HasEagerLimit;
    /**
     * @var array
     */
    protected $guarded = [];

    public function sub_category(): HasMany
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }
    public  function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
    public  function product_search(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public  function globalProduct(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->take(3);
    }

    public function category_tag(): BelongsToMany
    {
        return $this->belongsToMany(CategoryTag::class);
    }
    public function  subCategory(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent');
    }
    public function  subSubCategory(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent');
    }
    public function  tree(): array|Collection
    {
        return static::with(implode('.', array_fill(0, 100, 'subCategory')))->where('parent', '=', null)->get();
    }

    public function seo(): HasOne
    {
        return $this->hasOne(CategorySeo::class);
    }
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    public  function product_edit(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function grocery_product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->limit(12);
    }

    public function all_grocery_product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }



    public function category_with_all_child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent')->with('category_with_all_child');
    }

    public function all_product($categories_ids): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->wherePivotIn('category_id', $categories_ids);
    }


    public function category_with_all_parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent')->with('category_with_all_parent');
    }


}
