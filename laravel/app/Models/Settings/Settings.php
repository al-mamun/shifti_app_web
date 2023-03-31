<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable=[
    	'contact_title',
        'contact_content',
        'phone',
        'email',
        'address',
        'google_map',
        'admin_email',
        'logo',
        'retina_logo',
        'copyright'
    ];

}

