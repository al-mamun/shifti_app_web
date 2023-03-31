<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($photo)
 * @method static findOrFail(int $id)
 * @method static latest()
 */
class ProductPhoto extends Model
{
    use HasFactory;
    protected $guarded = [];
}
