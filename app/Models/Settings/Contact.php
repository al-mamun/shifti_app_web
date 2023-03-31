<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table ='contact_seetings';
    protected $fillable=[
    	'contact_title',
        'contact_content',
        'phone',
        'email',
        'address',
        'google_map',
        'admin_email'
    ];
}
