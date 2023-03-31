<?php

namespace App\Http\Controllers\API\Backend\Joblist;

use App\Http\Controllers\Controller;
use App\Models\Jobcategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.joblist.category.create');
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
            'name' => 'required'
        ]);
        $joblist = new Jobcategory;
        $joblist->name = $request->name;
        $joblist->save();
        return redirect('/admin/joblist/categories/show')->with('success',"Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
         $jobcategories = Jobcategory::latest()->paginate(2);
         return view('admin.joblist.category.index',compact('jobcategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcategory $jobcategory)
    {
        //
    }
}
