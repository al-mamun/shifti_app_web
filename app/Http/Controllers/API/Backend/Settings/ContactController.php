<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Contact;
use App\Models\FAQ\Faq;
use App\Models\Emailhistory;
use App\Models\Settings\Settings;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Mail;
use App\Models\Visitors;

class ContactController extends Controller
{
    public function contactView(Request $request)
    {
        $contact = Contact::first();
        $faq = Faq::get();
        $status = $request->status;
        return view('admin.settings.contact.index',compact('contact','faq','status'));
    } 
    
    public function SaveContact(Request $request)
    {
        $this->validate($request, [
            'contact_title' => 'required'
        ]);

        $contact = Contact::first();
        $contact->page_title          = $request->page_title;
        $contact->page_content        = $request->page_content;
        $contact->from_header_title   = $request->from_header_title;
        $contact->from_header_content = $request->from_header_content;
        $contact->contact_title       = $request->contact_title;
        $contact->contact_content     = $request->contact_content;
        $contact->phone               = $request->phone;
        $contact->email               = $request->email;
        $contact->address             = $request->address;
        $contact->google_map          = $request->google_map;
        $contact->admin_email         = $request->admin_email;
        
        if($contact->save()) {
            return redirect('admin/contact?status=success')->with('success','contact save succesfully');
        }
        
    }
    
    
    public function contactUsSend(Request $request) {
        
        $settingInfo = Settings::first();
        
        $data = [
            'name'         => $request->fullName,
            'fullName'     => $request->fullName,
            'email'        => $request->email,
            'admin_email'  => $settingInfo->admin_email,
            'message'      => $request->message,
            'company_name' => $request->company_name,
            'email_title'  => "Contact us",
        ];
        
        Mail::send(['html' => 'emails.contact_email'], compact('data'), function($message) use ($data) {
        // Mail::send('emails.contact_email', $data, function($message) {
         $message->to($data['admin_email'], 'Shifti')->subject
            ('Contact Mail');
         $message->from('shifti@mamundevstudios.com','Shifti');
        });
        
        // $request->fullName,$request->email,$request->email message
        Emailhistory::emailSendList($request->fullName,  "Contact Email", $request->message, 2,99999,$request->company_name, $request->email);
        
        $message =[
            'msg' =>'Email has successfully sent',
         ];
        return json_encode($message);

       
    }
    
    
    private function visitorCountPage() {
        
        $fn = public_path('contact_total_visiotrs.txt');
        
        $total_visiotrs = 0;
        // read current total_visiotrs
        if (($total_visiotrs = file_get_contents($fn)) === false)
        {
           $total_visiotrs = 0;
        }
        // write one more hit
        if (!isset($_SESSION['page_visited_already']))
        {
           if (($fp = @fopen($fn, 'w')) !== false)
           {
              if (flock($fp, LOCK_EX))
              {
                 $total_visiotrs++;
                
                 
                 fwrite($fp, $total_visiotrs, strlen($total_visiotrs));
                 flock($fp, LOCK_UN);
                 $_SESSION['page_visited_already'] = 1;
              }
              fclose($fp);
           }
        }
        $today = date('Y-m-d');
        
        $visitorSave = Visitors::where('page_slug', 'contact')
            ->where('date', $today)
            ->first();
        
        if(empty($visitorSave)) {
            $visitorSave = new Visitors();
            $visitorSave->page_slug     = 'contact'; 
            $visitorSave->total_visitor = $total_visiotrs;
            $visitorSave->date          = $today;
            $visitorSave->save();
        } else {

            $visitorSave->total_visitor = $total_visiotrs;
            $visitorSave->save();
            
        }
    }
    
    
    public function contactContent()
    {
        
        $this->visitorCountPage();
        $contactInfo = Contact::first();
        
        
        $contactArray= [
            'page_title'            => $contactInfo->page_title,
            'page_content'          => $contactInfo->page_content,
            'google_map'            => $contactInfo->google_map,   
            'contact_title'         => $contactInfo->contact_title, 
            'contact_details'       => $contactInfo->contact_content,
            'from_header_title'     => $contactInfo->from_header_title, 
            'from_header_content'   => $contactInfo->from_header_content, 
        ];
    
        return json_encode($contactArray);
    }
      public function contactApi()
    {
        $productInfoArray = [];

        $contactInfo = Contact::first();

         $productInfoArray []= [
            'label'      => 'Phone',
            'value'      => $contactInfo->phone,
            'icon'       => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 1C0 0.734784 0.105357 0.48043 0.292893 0.292893C0.48043 0.105357 0.734784 0 1 0H3.153C3.38971 0.000108969 3.6187 0.0841807 3.79924 0.23726C3.97979 0.390339 4.10018 0.602499 4.139 0.836L4.879 5.271C4.91436 5.48222 4.88097 5.69921 4.78376 5.89003C4.68655 6.08085 4.53065 6.23543 4.339 6.331L2.791 7.104C3.34611 8.47965 4.17283 9.72928 5.22178 10.7782C6.27072 11.8272 7.52035 12.6539 8.896 13.209L9.67 11.661C9.76552 11.4695 9.91994 11.3138 10.1106 11.2166C10.3012 11.1194 10.5179 11.0859 10.729 11.121L15.164 11.861C15.3975 11.8998 15.6097 12.0202 15.7627 12.2008C15.9158 12.3813 15.9999 12.6103 16 12.847V15C16 15.2652 15.8946 15.5196 15.7071 15.7071C15.5196 15.8946 15.2652 16 15 16H13C5.82 16 0 10.18 0 3V1Z" fill="white"/>
</svg>

',
        ];
        $productInfoArray []= [
            'label'      => 'Email',
            'value'      => $contactInfo->email,
            'icon'       => '<svg width="16" height="8" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16 0.118164L8 4.11816L0 0.118164V6.00016C0 6.5306 0.210714 7.0393 0.585786 7.41438C0.960859 7.78945 1.46957 8.00016 2 8.00016H14C14.5304 8.00016 15.0391 7.78945 15.4142 7.41438C15.7893 7.0393 16 6.5306 16 6.00016V0.118164Z" fill="white"/>
</svg>

',
        ];
        
         $productInfoArray []= [
            'label'      => 'Address',
            'value'      => $contactInfo->address,
            'icon'       => '<svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M2.05051 2.05036C3.36333 0.737536 5.14389 0 7.0005 0C8.85711 0 10.6377 0.737536 11.9505 2.05036C13.2633 3.36318 14.0009 5.14375 14.0009 7.00036C14.0009 8.85697 13.2633 10.6375 11.9505 11.9504L7.0005 16.9004L2.05051 11.9504C1.40042 11.3003 0.884739 10.5286 0.532912 9.67931C0.181084 8.82998 0 7.91967 0 7.00036C0 6.08104 0.181084 5.17073 0.532912 4.32141C0.884739 3.47208 1.40042 2.70038 2.05051 2.05036ZM7.0005 9.00036C7.53094 9.00036 8.03965 8.78964 8.41472 8.41457C8.78979 8.0395 9.00051 7.53079 9.00051 7.00036C9.00051 6.46992 8.78979 5.96122 8.41472 5.58614C8.03965 5.21107 7.53094 5.00036 7.0005 5.00036C6.47007 5.00036 5.96136 5.21107 5.58629 5.58614C5.21122 5.96122 5.0005 6.46992 5.0005 7.00036C5.0005 7.53079 5.21122 8.0395 5.58629 8.41457C5.96136 8.78964 6.47007 9.00036 7.0005 9.00036Z" fill="white"/>
</svg>

',
        ];

         return json_encode($productInfoArray);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
   $this->validate($request, [
            'contact_title' => 'required',
            'contact_content' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'admin_eamil' => 'required',
        ]);

        $contact = new Contact;
        $contact->contact_title = $request->contact_title;
        $contact->contact_content = $request->contact_content;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->google_map = $request->google_map;
        $contact->admin_eamil = $request->admin_eamil;
        $contact->save();
        return ("Created Successfully");
    }
}
