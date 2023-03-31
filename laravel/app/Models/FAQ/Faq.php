<?php

namespace App\Models\FAQ;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
     protected $fillable=[
    	'title',
        'content',
        'type'
    ];
}
