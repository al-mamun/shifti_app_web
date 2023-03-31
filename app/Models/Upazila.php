<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $upazila)
 * @method static where(string $string, int $id)
 */
class Upazila extends Model
{
    use HasFactory;
    protected $guarded = [];
}
