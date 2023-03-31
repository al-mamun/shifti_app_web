<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 * @method static create(array $temp_photo)
 */
class TemporaryPhoto extends Model
{
    use HasFactory;

    protected $guarded=[];
}
