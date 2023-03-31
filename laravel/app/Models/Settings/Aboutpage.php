<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutpage extends Model
{
    use HasFactory;
    protected $table = 'about_page';
    protected $fillable=[
    	'title',
    	'content'
    ];
}
