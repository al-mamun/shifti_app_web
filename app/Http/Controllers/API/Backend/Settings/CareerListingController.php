<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\CareerListing;
use Illuminate\Http\Request;

class CareerListingController extends Controller
{
    public function careerListingView(){
        $careerViews = CareerListing::first();
        return view('admin.settings.career.save',compact('careerViews'));
    }
    
    public function careerSave(Request $request){
       
     
        $careerSave = CareerListing::first();
        $careerSave->page_title         = $request->page_title;
        $careerSave->page_sub_title     = $request->page_sub_title;
        $careerSave->page_content       = $request->page_content;
        $careerSave->page_sub_content   = $request->page_sub_content;
        $careerSave->about_page_title   = $request->about_page_title;
        $careerSave->about_page_content = $request->about_page_content;
        $careerSave->page_company_content   = $request->page_company_content;
        $careerSave->page_company_title = $request->page_company_title;
      
        if($image=$request->file('image')){

            $destinationPath = public_path('images');
            $careerImage    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $careerImage);
            $input['image']=$careerImage;

        }
        $careerSave->save();
        return redirect()->back()->with('success','save succesfully');
    }
}
