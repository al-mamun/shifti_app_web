<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(mixed $district)
 * @method static where(string $string, int $id)
 */
class District extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function thana(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }
}
