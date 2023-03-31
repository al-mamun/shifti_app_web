<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joblocation extends Model
{
    use HasFactory;
    protected $table = 'job_locations';
       protected $fillable=[
      'location'
    ];
}
