<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $forget_password_data)
 * @method static where(string $string, mixed $input)
 */
class CustomerPasswordResetOtp extends Model
{
    use HasFactory;
    protected $guarded = [];
}
