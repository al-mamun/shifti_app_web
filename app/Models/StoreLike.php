<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 * @method static create(array $data)
 */
class StoreLike extends Model
{
    use HasFactory;
    protected $guarded = [];
}
