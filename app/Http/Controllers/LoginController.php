<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Hash;
use Auth;

class LoginController extends Controller
{
    
    public function login() {
       
        return view('admin.auth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   


    public function adminLogout() {

        Auth::logout();
        return redirect('/login')->with([
            'status' => 1,
            'error' => "Your user role isn't assigned.",
        ]);
        
    }
     public function userView() {
       $userList = Register::latest()->paginate();
        return view('admin.settings.user.userlist',compact('userList'));
    }
     public function adminProfile(Request $request) {
       $userProfile = Register::findOrFail($request->id);
       return view('admin.settings.user.view-profile',compact('userProfile'));
    }

    
     public function userSetup() {
       
        return view('admin.settings.user.createuser');
    }
       public function userStore(Request $request )
    {
        
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required|max:11',
            'photo'=>'image|mimes:jpeg,png,jpg,giv',
        ]);
        
        $userInfo = new Register();
        $userInfo->name     = $request->get('name');
        $userInfo->email    = $request->get('email');
        $userInfo->phone    = $request->get('phone');
        $userInfo->country    = $request->get('country');
        $userInfo->city    = $request->get('city');
        $userInfo->password = Hash::make($request->get('password'));
        $userInfo->role_id  = 1;
        $userInfo->type     = 1;
        if($photo=$request->file('photo')){

            $destinationPath = public_path('images/user');
            $profileImage    = date('YmDHis').".".$photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $userInfo['photo']=$profileImage;

        }else{
            unset($userInfo['photo']);
        }
        
        $userInfo->save();
        return redirect('/admin/userlist')->with('success','User Created Succesfully');
        
        //  return $request->all();
     
   /*     $userInfo = new Register();
        
        $userInfo->name     = $request->get('name');
        $userInfo->email    = $request->get('email');
        $userInfo->phone    = $request->get('phone');
        $userInfo->country    = $request->get('country');
        $userInfo->city    = $request->get('city');
        $userInfo->password = Hash::make($request->get('password'));
        $userInfo->role_id  = 1;
        $userInfo->type     = 1;
        $userInfo->save();*/

    }
    public function userEdit($id) 
    {
      $userInfoUpdate = Register::find($id);
      return view('admin.settings.user.edit',compact('userInfoUpdate'));
    }
    public function userUpdate(Request $request ,$id)
    {
        //  return $request->all();
     
        $userInfoUpdate = Register::find($id);
        
        $userInfoUpdate->name  = $request->get('name');
        $userInfoUpdate->email = $request->get('email');
        
        if(!empty($request->get('password'))) {
            $userInfoUpdate->password = Hash::make($request->get('password'));  
        }
        
        $userInfoUpdate->save();
        return redirect('/admin/userlist')->with('success','User Updated Succesfully');

    }
     public function delete($id)
       {
            $userInfoDelete = Register::find($id);
            $userInfoDelete->delete();
            return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
            
        }
}
