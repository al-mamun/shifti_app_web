<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($data)
 * @method static orderBy(string $string, string $string1)
 */
class Country extends Model
{
    use HasFactory;

    protected $guarded = [];
}
