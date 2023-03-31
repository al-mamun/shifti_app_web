<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $id)
 * @method static create(array $data)
 */
class BrandLike extends Model
{
    use HasFactory;

    protected $guarded = [];
}
