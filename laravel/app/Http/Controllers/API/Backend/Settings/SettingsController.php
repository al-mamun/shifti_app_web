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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
       //
    }
    public function adminSetUp(Settings $settings)
    {
        $setup = Settings::first();
        return view('admin.settings.setup.save',compact('setup'));
    }

    public function adminSetUpStore(Request $request, Settings $settings)
    {
        $this->validate($request, [
            'logo' => 'required|mimes:jpeg,jpg,png|max:5000',
            'retina_logo' => 'required|mimes:jpeg,jpg,png|max:5000',
            'copyright' => 'required',
        ]);

        $setup = Settings::first();
        $setup->copyright = $request->copyright;
        
          if($image=$request->file(['logo','retina_logo'])){

            $destinationPath = public_path('images/logo/');
            $logoImage    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $logoImage);
            $setup['logo']=$logoImage;
            $setup['retina_logo']=$logoImage;

        }
 /*       $height = 250;
        $width = 250;
        $path = 'images/logo/';
        $name = $setup['slug'].'-'.$setup['slug_id'];
        if ($request->logo) {
            $file = $request->logo;
            $setup['logo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $setup['logo'] = null;
        }*/
        $setup->save();
        return redirect()->back()->with('success','contact save succesfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
    
}
