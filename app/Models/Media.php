<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($data)
 * @method static paginate(mixed $limit)
 * @method static where(string $string, string $string1, string $string2)
 */
class Media extends Model
{
    use HasFactory;

    protected $guarded = [];
}
