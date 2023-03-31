<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Aboutpage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
     public function aboutView(){
         
        $aboutPage = Aboutpage::first();
        return view('admin.settings.about.index',compact('aboutPage'));
        
    }
    
    public function aboutSave(Request $request){
        
         $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        $aboutPage = Aboutpage::first();
        $aboutPage->title             = $request->title;
        $aboutPage->sub_ititle        = $request->sub_ititle;
        $aboutPage->content           = $request->content;
        $aboutPage->why_we_are        = $request->why_we_are;
        $aboutPage->our_prcess        = $request->our_prcess;
        $aboutPage->gallery_title     = $request->gallery_title;
        $aboutPage->gallery_sub_title = $request->gallery_sub_title;
        $aboutPage->gallery_content   = $request->gallery_content;
        if($aboutPage->save()) {
            return redirect()->back()->with('success','save succesfully');
        }
       
    }
    
    public function aboutPageContent() {
    
    $homePageinfo = Aboutpage::first();
      
        $craetedAt = date("d M ", strtotime($homePageinfo->created_at)); 
            
        $feature = explode(',',$homePageinfo->feature);
         
        $hompageContent =[
            'ID'                     => $homePageinfo->id,
            'title'                  => $homePageinfo->title,
            'content'                => $homePageinfo->content,
            'sub_ititle'             => $homePageinfo->sub_ititle,
            'why_we_are'             => $homePageinfo->why_we_are,
            'our_prcess'             => $homePageinfo->our_prcess,
            'gallery_title'          => $homePageinfo->gallery_title,
            'gallery_sub_title'      => $homePageinfo->gallery_sub_title,
            'gallery_content'        => $homePageinfo->gallery_content,

            
        ];
        
        return json_encode($hompageContent);
    }
}
