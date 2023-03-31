<?php

namespace App\Http\Controllers\API\Backend\Team;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Team;
use Illuminate\Http\Request;
use Session;
use URL;

class TeamController extends Controller
{
    
    public function teamList() {
        
        $team = Team::get();
        $teamList  = [];
        
        foreach($team as $teamInfo) {
           
            $teamList[] =[
                'ID'              => $teamInfo->id,
                'name'            => $teamInfo->title,
                'title'           => $teamInfo->designation,
                'avatar'          =>  URL::asset('images/'.$teamInfo->image)
                
            ];
         
        }
         return json_encode($teamList); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamlists = Team::latest()->paginate();
        return view('admin.team.index',compact('teamlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.create');
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
           'title' => 'required',
           'designation' => 'required',
           'image' => 'required|mimes:jpeg,jpg,png|max:5000',
           ]);
            $data = $request->all();
            if($image=$request->file('image')){

                $destinationPath = public_path('images');
                $profileImage    = date('YmDHis').".".$image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $data['image']=$profileImage;
    
               }else {
                $data['image'] = null;
            }

            Team::create($data);

           return redirect('admin/team')->with('success',"Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);
        return view('admin.team.edit',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
       
        $this->validate($request, [
           'title' => 'required',
           'designation' => 'required',
           'image' => 'required|mimes:jpeg,jpg,png|max:5000',
           ]);
            $data = $request->all();
            if($image=$request->file('image')){

                $destinationPath = public_path('images');
                $profileImage    = date('YmDHis').".".$image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $data['image']=$profileImage;
    
               }else {
                $data['image'] = null;
            }

           $team->update($data);
           return redirect('admin/team')->with('success',"Updated  Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        Session::flash('success', 'Data Deleted Successfully.');
        return redirect('admin/team')->with('success',"Data Deleted Successfully.");
    }
}
