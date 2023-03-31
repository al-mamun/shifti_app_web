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
    
    /**
     * Email Send List
     * */
    static public function emailSendList($name, $subject, $body,$type, $typeId,$companyName, $email=NULL) {
        
        $emailHistory = new Emailhistory();
        $emailHistory->name         = $name;
        $emailHistory->subject      = $subject;
        $emailHistory->body         = $body;
        $emailHistory->type         = $type;
        $emailHistory->type_id      = $typeId;
        $emailHistory->company_name = $companyName;
        
        if(!empty($email)) {
            $emailHistory->email        = $email;   
        }
       
        $emailHistory->save();
    }
}
