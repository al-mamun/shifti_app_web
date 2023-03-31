<?php

namespace App\Http\Controllers\API\Backend\Page;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $pages = Pages::latest()->paginate(5);
          return view('admin.pages.index',compact('pages'))->with
          ('i',(request()->input('page',1)-1)*5);
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
        $this->validate($request, [
            'title'       =>'required',
            'page_name'   =>'required'
        ]);
        
        $page = new Pages;
        $page->title       =  $request->title;
        $page->page_name   =  $request->page_name;
        $page->description =  $request->description;
        $page->save();
        return redirect('/admin/pages')->with('success',"Created Successfully");
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
    public function update(Request $request, Pages $pages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $pageDelete = Pages::findOrFail($id);
         $pageDelete->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
