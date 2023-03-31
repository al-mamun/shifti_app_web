<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;

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
   


    public function logout() {

        Auth::logout();
        return redirect('/admin_login')->with([
            'status' => 1,
            'error' => "Your user role isn't assigned. You can't login. Please contact to PCB.",
        ]);
        
    }
     public function userView() {
       $userList = Register::latest()->paginate();
        return view('admin.settings.user.userlist',compact('userList'));
    }
     public function userSetup() {
       
        return view('admin.settings.user.createuser');
    }
       public function userStore(Request $request )
    {
        //  return $request->all();
     
        $userInfo = new Register();
        
        $userInfo->name = $request->get('name');
        $userInfo->email = $request->get('email');
        $userInfo->password = $request->get('password');
        $userInfo->save();
        return redirect('/admin/userlist')->with('success','User Created Succesfully');

    }
    public function userEdit($id) 
    {
      $userInfoUpdate = Register::find($id);
      return view('admin.settings.user.edit',compact('userInfoUpdate'));
    }
    public function userUpdate(Request $request )
    {
        //  return $request->all();
     
        $userInfoUpdate = new Register();
        
        $userInfoUpdate->name = $request->get('name');
        $userInfoUpdate->email = $request->get('email');
        $userInfoUpdate->password = $request->get('password');
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
