<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1)
 * @method static create(array $sms_data)
 * @method static lastest()
 * @method static orderBy(string $string, string $string1)
 */
class SMS extends Model
{
    use HasFactory;
    protected $guarded = [];
}
