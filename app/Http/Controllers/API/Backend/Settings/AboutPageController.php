<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Aboutpage;
use Illuminate\Http\Request;
use App\Models\Visitors;

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
        $aboutPage->story_title       = $request->story_title;
        $aboutPage->story_content     = $request->story_content;
        $aboutPage->why_we_are        = $request->why_we_are;
        $aboutPage->our_prcess        = $request->our_prcess;
        $aboutPage->gallery_title     = $request->gallery_title;
        $aboutPage->gallery_sub_title = $request->gallery_sub_title;
        $aboutPage->gallery_content   = $request->gallery_content;
        if($aboutPage->save()) {
            return redirect()->back()->with('success','save succesfully');
        }
       
    }
    
      private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    private function visitorCountPage() {
        
        $$visitorSave = new Visitors();
        $visitorSave->page_slug     = 'about'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    public function aboutPageContent(Request $request) {
        session_name('mysite_hit_counter');
        session_start();

        $homePageinfo = Aboutpage::first();
      
        $craetedAt = date("d M ", strtotime($homePageinfo->created_at)); 
            
        $feature = explode(',',$homePageinfo->feature);
        
        if($request->type) {
            
        }
   
        if(!empty($request->type) && $request->type==2) {
            
             $this->visitorCountPage();
             
            $hompageContent =[
             
                'story_title'     => $homePageinfo->story_title,
                'story_content'   => $homePageinfo->story_content,
                'story_thumbnail' => $homePageinfo->story_thumbnail,
            ]; 
            
        } else {
            
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
        }
        
        
        return json_encode($hompageContent);
    }
}
