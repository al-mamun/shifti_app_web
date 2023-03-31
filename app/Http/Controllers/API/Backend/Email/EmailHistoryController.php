<?php

namespace App\Http\Controllers\API\Backend\Email;

use App\Http\Controllers\Controller;
use App\Models\Emailhistory;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Settings\Settings;
use App\Models\Joblist;
use Mail;
use App\Models\JobApplyList;

class EmailHistoryController extends Controller
{
    public function emailHistory() {
        
        $emailhistory = Emailhistory::latest()->paginate(100);
        
        return view('emails.index',compact('emailhistory'));
    }
    
    public function storeEmail(Request $request){
        
        $this->validate($request, [
            'title'  => 'required',
            'subject'  => 'required',
            'body'  => 'required'
        ]);
        $data = $request->all();
 
        Support::create($data);
        return redirect('/email/history')->with('success',"Created Successfully");

    
    }
    
    
    public function storeEmails(Request $request) {
        
         $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'subject' => 'required',
            'email'   => 'required',
            'body' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $title = 'Email For '. $request->title;
        
        $data = array(
            'name'         => "Shifti", 
            'type'         => "Job", 
            'message'      => $request->body, 
            'email'        => $request->email,
            'job_title'    => $request->title,
            'email_title'  => $title,
        );
        
        
        Mail::send(['html' => 'emails.job_mail'], compact('data'), function($message) use ($data) {
         $message->to($data['email'], $data['email_title'])->subject
            ('Replay Email');
         $message->from('shifti@mamundevstudios.com','Shifti');
        });  
        
        Emailhistory::emailSendList('',  $title,  $request->body,  6, 0,'');// 6 fo new email
 
        $statuArray = [
            'status' => 200,
            'message' => "Successfully send data",
        ];
        
        return json_encode($statuArray);
        
    
    }
    
    public function sendReplay(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
    
        $settingInfo = Settings::first();
                
        $title = 'Replay For '. $request->job_title;
        
        $joblistInfo = JobApplyList::find($request->job_id);
        
        $data = array(
            'name'         => "Shifti", 
            'type'         => "Job", 
            'message'      => $request->body, 
            'email'        => $joblistInfo->email,
            'job_title'    => $request->job_title,
            'email_title'  => $title,
        );
        
        
        Mail::send(['html' => 'emails.job_mail'], compact('data'), function($message) use ($data) {
         $message->to($data['email'], $data['email_title'])->subject
            ('Replay job');
         $message->from('shifti@mamundevstudios.com','Shifti');
        });  
        
        Emailhistory::emailSendList($request->fullName,  $title,  $request->body,  4, $joblistInfo->id,'');// 3 job type
 
        $statuArray = [
            'status' => 200,
            'message' => "Successfully send data",
        ];
        
        return json_encode($statuArray);

    }
    
    public function Delete($id){
        $emailhistoryDelete = Emailhistory::first();
        $emailhistoryDelete->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
    
    /**
     * 
     * */
    public function adminSubscriberList() {
        $emailSubscribe = Subscribe::latest()->paginate(51);
        return view('emails.subcriber_list',compact('emailSubscribe'));
    }
}
