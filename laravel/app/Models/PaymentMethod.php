<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $method)
 * @method static select(string $string, string $string1)
 */
class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable=[
    	'STRIPE_KEY',
        'STRIPE_SECRET',
        'STRIPE_WEBHOOK_SECRET'
    ];
}
