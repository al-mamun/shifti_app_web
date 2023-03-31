<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static orderBy(string $string, string $string1)
 * @method static latest()
 * @method static findOrFail(int $int)
 * @method static where(string $string, $id)
 */
class Store extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function follow()
    {
        return $this->hasMany(StoreFollow::class);
    }

    public function like()
    {
        return $this->hasMany(StoreLike::class);
    }
}
