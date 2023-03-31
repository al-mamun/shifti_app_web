<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBilling extends Model
{
    protected $table = 'customer_billing_information';
    public $timestamp = true;
    
}
