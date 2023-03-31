<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $log)
 */
class ActivityLog extends Model
{
    use HasFactory;
    protected $guarded = [];
}
