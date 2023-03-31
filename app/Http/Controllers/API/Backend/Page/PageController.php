<?php

namespace App\Http\Controllers\API\Backend\Page;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $pages = Pages::latest()->paginate(100);
         
         return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'page_name'  => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $page1 ='';
        
        if ($image = $request->file('page_image')) {
            
            $destinationPath = 'images/uploads/page/';
            $page = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($destinationPath, $page);
            $page1 = "$page";
        }
        
        $page = new Pages;
        $page->title       = $request->title;
        $page->page_name   = $request->page_name;
        $page->description = $request->description;
        $page->thumbnail   = $page1;
        
        if($page->save()) {
            
            return response()->json([
                'msg'    => 'Add new record succssfully.',
                'status' => 200,
            ]);
   
        }
        return response()->json([
            'msg'    => 'Something want wrong.',
            'status' => 400,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pages = Pages::find($id);
        return view('admin.pages.show',compact('pages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(Pages $pages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function pageUpdate(Request $request)
    {

         $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'page_name'  => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
        
        $page = Pages::find($request->id);
        
        if ($image = $request->file('page_image')) {
            
            $destinationPath = 'images/uploads/page/';
            $pages = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($destinationPath, $pages);
            $page->thumbnail =  $pages;
        }
        
        $page->title       =  $request->title;
        $page->page_name   =  $request->page_name;
        $page->description =  $request->description;
        
        if($page->save()) {
            
            return response()->json([
                'msg'    => 'update record succssfully.',
                'status' => 200,
            ]);
   
        }
        return response()->json([
            'msg'    => 'Something want wrong.',
            'status' => 400,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         /*$pageDelete = Pages::findOrFail($id);
         $pageDelete->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);*/
    } 
    public function pagedelete($id)
    {
         $pageDelete = Pages::find($id);
         $pageDelete->delete();
         return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
