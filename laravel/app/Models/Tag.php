<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $data)
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail(int $id)
 * @method static where(string $string, string $string1, string $string2)
 */
class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
