<?php

namespace App\Http\Controllers\API\Backend\Settings;
use App\Helpers\Helper;
use App\Models\FAQ\Faq;
use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Mail;

class SettingsController extends Controller
{
    public function mailTest() {
        
        $data = array('name'=>"Shifti");
        Mail::send('mail', $data, function($message) {
         $message->to('ratonkumarcse@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('shifti@mamundevstudios.com','Shifti');
        });
        echo "HTML Email Sent. Check your inbox.";
        
    }
   


      public function contactApi()
    {
        $productInfoArray = [];

        $contactInfo = Settings::first();

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

   
    public function adminSetUp(Settings $settings)
    {
        $setup = Settings::first();
        
        return view('admin.settings.setup.save',compact('setup'));
    }

    public function adminSetUpStore(Request $request, Settings $settings)
    {
        $this->validate($request, [
            // 'logo'         => 'required|mimes:jpeg,jpg,png|max:5000',
            // 'retina_logo'  => 'required|mimes:jpeg,jpg,png|max:5000',
            'copyright'    => 'required',
        ]);

        $setup = Settings::first();
        $setup->copyright   = $request->copyright;
        $setup->admin_email = $request->admin_email;
        
        $destinationPath = public_path('images/global/');
        
        if($image = $request->file('logo')){

          
            $logoImage    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $logoImage);
            $setup->logo         = $logoImage;
            // $setup['retina_logo']=$logoImage;

        }
        
         if($image = $request->file('footer_logo')){

            
            $logoImageFotter    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $logoImageFotter);
            $setup->footer_logo         = $logoImageFotter;
            // $setup['retina_logo']=$logoImage;

        }

        $setup->save();
        return redirect()->back()->with('success','Data save succesfully');
    }
    
    
    /**
     * Global Api
     * */
    public function settingApi() {
        
        $setup = Settings::first();
         
        $settingApi = [
            'copyright_text'    => 'Phone',
            'logo'              => asset('images/global/' . $setup->logo),
            'footer_logo'              => asset('images/global/' . $setup->footer_logo),
            'ratina_logo'       => '',
        ];
        
         return json_encode($settingApi);
        
    }

   
    
}
