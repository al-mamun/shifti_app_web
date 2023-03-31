<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;
     protected $table = 'terms';
     protected $fillable=[
    	'title',
        'content'
    ];
}
