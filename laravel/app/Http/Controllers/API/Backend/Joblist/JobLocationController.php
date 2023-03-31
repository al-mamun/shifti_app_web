<?php

namespace App\Http\Controllers\API\Backend\Joblist;

use App\Http\Controllers\Controller;
use App\Models\Joblocation;
use Illuminate\Http\Request;

class JobLocationController extends Controller
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
        return view('admin.joblist.location.create');
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
            'location' => 'required'
        ]);
        $joblist = new Joblocation;
        $joblist->location = $request->location;
        $joblist->save();
        return redirect('/admin/joblist/locations/show')->with('success',"Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Joblocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
         $joblocations = Joblocation::latest()->paginate(2);
         return view('admin.joblist.location.index',compact('joblocations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Joblocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Joblocation $joblocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Joblocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Joblocation $joblocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Joblocation  $joblocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Joblocation $joblocation)
    {
        //
    }
}
