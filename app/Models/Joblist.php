<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
    use HasFactory;
    
    protected $fillable=[
      'job_title',
      'type',
      'job_category',
      'expire_date',
      'date',
      'job_location',
      
    ];
}
