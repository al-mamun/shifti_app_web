<?php

namespace App\Http\Controllers\API\Backend\FAQ;

use App\Http\Controllers\Controller;
use App\Models\FAQ\Faq;
use App\Models\Terms\Terms;
use Illuminate\Http\Request;

class FaqController extends Controller
{
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
    public function termsApi(){
        
        $termArray = [];

        $termInfo = Terms::all();

        foreach( $termInfo as $con) {

            $craetedAt = date("d M ", strtotime($con->created_at)); 
     
            $termArray[] =[
                'ID'          => $con->id,
                'title'       => $con->title,
                'subtitle'    => $con->content,
                'type'        => $con->type,
            ];
        }

         return json_encode($termArray);
    }
    public function termView()
        {
             $terms = Terms::get();
             return view('admin.settings.terms.index',compact('terms'));
        }
    public function termSave(Request $request)
        {
            // $this->validate($request, [
            //     'title'       =>'required',
            //     'content'     =>'required',
            //     'type'        =>'required'
            // ]);
            
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
