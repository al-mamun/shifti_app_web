<?php

namespace App\Http\Controllers\API\Backend\User;

use App\Http\Controllers\Controller;

use App\Http\Resources\Backend\User\UserSetupResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;


class UserSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        //$users  = User::latest()->get();


        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $users = User::with('role')->orderBy('created_at', 'desc')->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $users = User::with('role')->orderBy('created_at', 'asc')->paginate($pagination);
        }



//           $users  = User::with('role')->get();

        return  UserSetupResource::collection($users);
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
    public function store(Request $request )
    {
        //  return $request->all();
        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email|unique:users',

            'phone' => 'required|digits:11|unique:users',
            'password' => 'required|min:8|max:25|confirmed',

        ]);

        $data['email'] = $request->input('email');
        $data['name'] = $request->input('name');
        $data['phone'] = $request->input('phone');
        $data['role_id'] = $request->input('role_id');
//        $data['updated_by'] = auth()->user()->id;
//        $data = $request->except('photo');
        $data ['password'] = Hash::make($request->input('password'));

        if ($request->photo) {
            $name = $request->name . '-' . str_replace([' ', ':'], '-', Carbon::now());
            $path = 'images/uploads/users/';
            $file = $request->photo;
            $height = 300;
            $width = 300;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['photo'] = null;
        }
        $user = User::create($data);
        return response()->json(['msg' => 'User Created Successfully']);


        return response()->json([
            'status' => 200,
            'message' => 'User Added Successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::with('role')->findOrFail($id);
            return new UserSetupResource($user);
        } catch (ModelNotFoundException) {
            return  response()->json(['msg' => 'Data Not Found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        //  return $request->all();
        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,

            'phone' => 'required|digits:11|unique:users,phone,'.$user->id,
            'password' => 'confirmed|min:8|max:12',
//            'password' => 'required|min:8|max:12',
//            'password_confirmation' => 'required_with:password|same:password|min:8|max:12',
        ]);

        $data = $request->except('photo');
      //  $data['name'] = $request->input('name');
      //  $data['phone'] = $request->input('phone');
       // $data['role_id'] = $request->input('role_id');
//        $data['updated_by'] = auth()->user()->id;
        $data ['password'] = Hash::make($request->input('password'));

        if ($request->photo) {
            $name = $request->name . '-' . str_replace([' ', ':'], '-', Carbon::now());
            $path = 'images/uploads/users/';
            if ($user->photo !=null){
                Helper::unlinkImage($path, $user->photo);
            }
            $file = $request->photo;
            $height = 300;
            $width = 300;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['photo'] = $user->photo;
        }
        $user->update($data);
        return  response()->json(['msg' => 'User Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
