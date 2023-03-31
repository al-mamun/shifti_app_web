<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailhistory extends Model
{
    use HasFactory;
    protected $table = 'email_history';
    
    
    protected $fillable=[
        'title',
        'subject',
        'body',
        'type',
        'date'
    ];
    
    static public function emailSendList($title, $subject, $body,$type) {
        
       $emailHistory = new Emailhistory();
       $emailHistory->title    = $title;
       $emailHistory->subject  = $subject;
       $emailHistory->body     = $body;
       $emailHistory->type     = $type;
       $emailHistory->save();
    }
}
