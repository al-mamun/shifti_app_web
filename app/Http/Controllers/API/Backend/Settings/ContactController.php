<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Contact;
use App\Models\FAQ\Faq;
use App\Models\Emailhistory;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Mail;

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
        
        $data = [
            'name'      =>"Shifti",
            'fullName'  => $request->fullName,
            'email'     => $request->email,
            'message'   => $request->message,
        ];
        
      
        
        Mail::send(['html' => 'emails.contact_email'], compact('data'), function($message) use ($data) {
        // Mail::send('emails.contact_email', $data, function($message) {
         $message->to('ratonkumarcse@gmail.com', 'Shifti')->subject
            ('Contact Mail');
         $message->from('shifti@mamundevstudios.com','Shifti');
        });
        // $request->fullName,$request->email,$request->email message
        Emailhistory::emailSendList($request->fullName, $request->email, $request->message,2);
        
        $message =[
            'msg' =>'Email has successfully sent',
         ];
        return json_encode($message);

       
    }
    
    public function contactContent()
    {
        
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
            'icon'       => '<svg
        width={20}
        height={20}
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
      </svg>',
        ];
        $productInfoArray []= [
            'label'      => 'Email',
            'value'      => $contactInfo->email,
            'icon'       => '(
      <svg
        width={20}
        height={20}
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
      </svg>
    )',
        ];
        
         $productInfoArray []= [
            'label'      => 'Address',
            'value'      => $contactInfo->address,
            'icon'       => '(
      <svg
        width={20}
        height={20}
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fillRule="evenodd"
          d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
          clipRule="evenodd"
        />
      </svg>
    )',
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
