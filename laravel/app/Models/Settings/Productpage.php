<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productpage extends Model
{
    use HasFactory;
     protected $table = 'product_page';
     protected $fillable=[
      'title',
      'content',
      'banner',
      'url',
      'button_text'
    ];
}
