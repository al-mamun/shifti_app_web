<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Homepage;
use App\Models\Settings\HomePageReview;
use App\Models\Partner;
use URL;
use App\Models\Visitors;

class HomePageController extends Controller
{
    public function homeView() {
        $homePage = Homepage::first();
        return view('admin.settings.home.index',compact('homePage'));
    }
    
    public function homeSavehub(Request $request){
        
        $homePage = Homepage::first();
        
         if($request->hasFile('hub_thumbnail')){
            $image = $request->file('hub_thumbnail');
            $destinationPath = public_path('images/homepage');
            $thumbnail    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $thumbnail);
            $homePage->hub_thumbnail              = $thumbnail;
        }
        $homePage->hub_title    = $request->hub_title;
        $homePage->hub_content  = $request->hub_content;
       
        if($homePage->save()) {
           return redirect()->back()->with('success','save succesfully'); 
        }
    
    }
    
    
    public function homeSave(Request $request){
        
       
        $homePage = Homepage::first();
        
         if($request->hasFile('thumbnail')){
            $image = $request->file('thumbnail');
            $destinationPath = public_path('images/homepage');
            $thumbnail    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $thumbnail);
            $homePage->thumbnail              = $thumbnail;
        }
        $homePage->title                  = $request->title;
        $homePage->content                = $request->content;
        $homePage->team_title             = $request->team_title;
        $homePage->team_content           = $request->team_content;
        $homePage->feature                = $request->feature;
         
        $homePage->footer                 = $request->footer;
        if($homePage->save()) {
           return redirect()->back()->with('success','save succesfully'); 
        }
       
    }
    
 
     public function homeSaveproduct(Request $request){
        
        $homePage = Homepage::first();
        
         if($request->hasFile('product_content_banner')){
            $image = $request->file('product_content_banner');
            $destinationPath = public_path('images/homepage');
            $thumbnail    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $thumbnail);
            $homePage->product_content_banner              = $thumbnail;
        }
        
        if($request->hasFile('product_thumbnail')){
            $image = $request->file('product_thumbnail');
            $destinationPath = public_path('images/homepage');
            $thumbnail    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $thumbnail);
            $homePage->product_thumbnail              = $thumbnail;
        }
        $homePage->product_title          = $request->product_title;
        $homePage->product_content        = $request->product_content;
        $homePage->intigration           = $request->intiger;
        if($homePage->save()) {
           return redirect()->back()->with('success','save succesfully'); 
        }
    
    }
    
    public function homePageReviewcontent( Request $request) {
        
        $this->visitorCountPage();
        
        $homepageContent = HomePageReview::get();
        $review =[];
        
        foreach($homepageContent as $homePageReview){

             $review[] = [
                'title'           => $homePageReview->title,
                'subtitle'        => $homePageReview->content,
                'icon'            => $homePageReview->thumbnail,   
              
            ];
        }
        
         return json_encode($review);
    }
    
    public function homePagePartner() {
        
        
        $partnerArray = [];
        
        $partner = Partner::orderBy('id','desc')->get();

        foreach( $partner as $partnerInfo) {


            $partnerArray[] =[
                'ID'          => $partnerInfo->id,
                'logo'       => URL::asset('icon/'.$partnerInfo->partner_icon),
                'name'       => $partnerInfo->partner_name,
            ];
        }

         return json_encode($partnerArray);
    }
    
    // Function to get the client IP address
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
        
        // $fn = public_path('home_total_visiotrs.txt');
        // $total_visiotrs = 0;
        // // read current total_visiotrs
        // if (($total_visiotrs = file_get_contents($fn)) === false)
        // {
        //   $total_visiotrs = 0;
        // }
        // // write one more hit
        // if (!isset($_SESSION['page_visited_already']))
        // {
        //   if (($fp = @fopen($fn, 'w')) !== false)
        //   {
        //       if (flock($fp, LOCK_EX))
        //       {
        //          $total_visiotrs++;
                
                 
        //          fwrite($fp, $total_visiotrs, strlen($total_visiotrs));
        //          flock($fp, LOCK_UN);
        //          $_SESSION['page_visited_already'] = 1;
        //       }
        //       fclose($fp);
        //   }
        // }
        $today = date('Y-m-d');
        
        $visitorSave = new Visitors();
        $visitorSave->page_slug     = 'home'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
        
    }
    
    /**
     * Home page
     * */
    public function homePagecontent(Request $request) {
        
        $homePageinfo = Homepage::first();
      
        
        
        $craetedAt = date("d M ", strtotime($homePageinfo->created_at)); 
            
        $feature = explode(',',$homePageinfo->feature);
         
        $hompageContent =[
            'ID'                     => $homePageinfo->id,
            'title'                  => $homePageinfo->title,
            'content'                => $homePageinfo->content,
            'thumbnail'              =>  asset('images/homepage/' . $homePageinfo->thumbnail),
            'team_title'             => $homePageinfo->team_title,
            'team_content'           => $homePageinfo->team_content,
            'product_title'          => $homePageinfo->product_title,
            'product_content'        => $homePageinfo->product_content,
            'product_thumbnail'      =>  asset('images/homepage/' . $homePageinfo->product_thumbnail),
            'product_content_banner' =>  asset('images/homepage/' . $homePageinfo->product_content_banner),
            'hub_title'              => $homePageinfo->hub_title,
            'hub_content'            => $homePageinfo->hub_content,
            'partner_sub_title'              => $homePageinfo->partner_sub_title,
            'partner_title'            => $homePageinfo->partner_title,
            'partner_content'              => $homePageinfo->partner_content,
            'hub_thumbnail'          =>  asset('images/homepage/' . $homePageinfo->hub_thumbnail),
            'feature'          =>  $feature,
            
        ];
        
         return json_encode($hompageContent);
    }
}
