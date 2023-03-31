<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Stories;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function storiesView(Request $request){
        $storiesViews = Stories::first();
        $status = $request->get();
        
        return view('admin.settings.stories.save',compact('storiesViews','status'));
    }
    public function storiesSave(Request $request){
        
        
        $this->validate($request, [
            'page_title' => 'required',
          
          
        ]);

        $storiesSave = Stories::first();
        $storiesSave->page_title        = $request->page_title;
        $storiesSave->page_sub_title    = $request->page_sub_title;
        $storiesSave->page_content      = $request->page_content;
        $storiesSave->page_sub_content  = $request->page_sub_content;
        
        if($image=$request->file('image')){

            $destinationPath = public_path('images');
            $storiesImage    = date('YmDHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $storiesImage);
            $input['image']=$storiesImage;

        }
        $storiesSave->save();
        return redirect('admin/home?status=success')->back()->with('success','save succesfully');
    }
    
    
    public function store(Request $request) {
        return 100;
    }
}
