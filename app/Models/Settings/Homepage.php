<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    use HasFactory;
    protected $table = 'home_page';
    protected $fillable=[
    	'title',
    	'content',
    	'team_title',
    	'team_content',
    	'product_title',
    	'product_content',
    	'product_content_banner',
    	'footer',
    	'intigration'
    ];
}
