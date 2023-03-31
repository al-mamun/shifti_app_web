<?php

namespace App\Http\Controllers\API\Backend\FAQ;

use App\Http\Controllers\Controller;
use App\Models\FAQ\Faq;
use App\Models\Terms\TermsPage;
use App\Models\Terms\Terms;
use Illuminate\Http\Request;
use App\Models\Visitors;

class FaqController extends Controller
{
    
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
        
        $visitorSave = new Visitors();
        $visitorSave->page_slug     = 'faq'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    private function visitorCountPageTerms() {
        
        $visitorSave = new Visitors();
        $visitorSave->page_slug     = 'terms'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $faq = Faq::get();
         return view('admin.settings.faq.index',compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'title'       =>'required',
        //     'content'     =>'required',
        //     'type'        =>'required'
        // ]);
        
        $title     = $request->title;
        $content   = $request->content;
        $type      = $request->type;
        $faq_id    = $request->faq_id;
        
        foreach($title as $key=>$value) {
            if(empty($faq_id[$key])) {
                $contact = new Faq();
                $contact->title   = $title[$key];
                $contact->content = $content[$key];
                $contact->type    = $type[$key];
                $contact->save();   
            } else {
                $contactSave = Faq::where('id', $faq_id[$key])->first();
                if(!empty($contactSave)) {
                    $contactSave->title   = $title[$key];
                    $contactSave->content = $content[$key];
                    $contactSave->type    = $type[$key];
                    $contactSave->save(); 
                }
                 
            }
             
        }
        
       return redirect()->back()->with('success','FAQ save succesfully');
    }

     public function faqApi($faq)
    {
        
        $this->visitorCountPage();
       
        $productInfoArray = [];

        $faqInfo = Faq::where('type', $faq)->get();

        foreach( $faqInfo as $faq) {

            $craetedAt = date("d M ", strtotime($faq->created_at)); 
     
            $productInfoArray[] =[
                'ID'          => $faq->id,
                'title'       => $faq->title,
                'subtitle'    => $faq->content,
                'type'        => $faq->type,
            ];
        }

         return json_encode($productInfoArray);
    }
    
    
    public function termsApi(Request $request){
        
        $this->visitorCountPageTerms();
        
        $type = $request->type;
        
        if($type== 1) {
            $termArray = [];
        
            $termInfo = Terms::all();
    
            foreach( $termInfo as $con) {
    
                $craetedAt = date("d M ", strtotime($con->created_at)); 
         
                $termArray[] =[
                    'ID'          => $con->id,
                    'title'       => $con->title,
                    'description'    => $con->content,
                    'type'        => $con->type,
                ];
            }
        } else {
            
            $termArray = [];
        
            $termInfo = TermsPage::first();
    
            $termArray =[
                'ID'             => $termInfo->id,
                'page_title'    => $termInfo->page_title,
                'page_content'  => $termInfo->page_content,
            ];
            
        }
      
         return json_encode($termArray);
    }
    
    public function termView()
    {
        $terms = Terms::get();
        $termsPage = TermsPage::first();
         
        return view('admin.settings.terms.index',compact('terms','termsPage'));
    }
        
    public function termSave(Request $request)
        {
            // $this->validate($request, [
            //     'title'       =>'required',
            //     'content'     =>'required',
            //     'type'        =>'required'
            // ]);
            
            $termsPage = TermsPage::first();
            
            $termsPage->page_title   = $request->page_title;
            $termsPage->page_content = $request->page_content;
            $termsPage->save();
            
            $title     = $request->title;
            $content   = $request->content;
            $term_id    = $request->term_id;
            
            foreach($title as $key=>$value) {
                if(empty($term_id[$key])) {
                    $contact = new Terms();
                    $contact->title   = $title[$key];
                    $contact->content = $content[$key];
                    $contact->save();   
                } else {
                    $contactSave = Terms::where('id', $term_id[$key])->first();
                    if(!empty($contactSave)) {
                        $contactSave->title   = $title[$key];
                        $contactSave->content = $content[$key];
                        $contactSave->save(); 
                    }
                     
                }
                 
            }
            
           return redirect()->back()->with('success','Terms save succesfully');
        }
}
