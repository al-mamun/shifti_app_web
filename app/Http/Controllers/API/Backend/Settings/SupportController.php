<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function index() {
        $supports = Support::latest()->paginate();
        return view('admin.support.index',compact('supports'));
    }
    public function add() {
        return view('admin.support.add');
    }
    
    public function store(Request $request){
        $this->validate($request, [
                'title'  => 'required',
                'content'  => 'required',
                'image'  => 'required|mimes:jpeg,jpg,png|max:5000',
            ]);
            $data = $request->all();
            if($image=$request->file('image')){
                $destinationPath = public_path('images/support');
                $supportImage    = date('YmDHis').".".$image->getClientOriginalExtension();
                $image->move($destinationPath, $supportImage);
                $data['image']=$supportImage;
    
            }
     
             Support::create($data);
             return redirect('/admin/support')->with('success',"Created Successfully");

    
    }
    public function supportEdit($id) 
    {
      $supportInfoUpdate = Support::find($id);
      return view('admin.support.edit',compact('supportInfoUpdate'));
    }
    public function supportUpdate(Request $request, Support $supportInfoUpdate)
    {
           $this->validate($request, [
                'title'  => 'required',
                'content'  => 'required',
                'image'  => 'required|mimes:jpeg,jpg,png|max:5000',
            ]);
            $supportInfoUpdate = Support::first();
            if($image=$request->file('image')){
                $destinationPath = public_path('images/support');
                $supportImage    = date('YmDHis').".".$image->getClientOriginalExtension();
                $image->move($destinationPath, $supportImage);
                $data['image']=$supportImage;
    
            }
            $supportInfoUpdate->title                  = $request->title;
            $supportInfoUpdate->content                = $request->content;
            $supportInfoUpdate->update();
            return redirect('/admin/support')->with('success',"Created Successfully");
           

    }
     public function delete($id)
       {
            $support = Support::find($id);
            $support->delete();
            return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
            
        }

}
