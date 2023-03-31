<?php

namespace App\Http\Controllers;

use App\Http\Resources\APIAuthenticationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class APIAuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'name'          => 'required',
            'email'         => 'required|string|unique:users,email',
            'password'      => 'required|string|min:8',
        ]);
        $user = User::create([
            'name'      => $fields['name'],
            'email'     => $fields['email'],
            'password'  => Hash::make($fields['password']) ,
        ]);
        $token = $user->createToken('token')->plainTextToken;
        $response = [
            'user'      => $user,
            'token'     => $token,
        ];
        return response()->json($response, 201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return APIAuthenticationResource
     * @throws ValidationException
     */

    public function login(Request $request):APIAuthenticationResource
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'error_msg' => ['Credentials are incorrect.'],
            ]);
        }
        $user->token =  $user->createToken($user->name)->plainTextToken;
        return new APIAuthenticationResource($user) ;
    }
//    public function login(Request $request): APIAuthenticationResource
//    {
//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//        $user = User::where('email', $request->email)->first();
//
//        if (! $user || ! Hash::check($request->password, $user->password)) {
//            throw ValidationException::withMessages([
//                'error_msg' => ['Credentials are incorrect.'],
//            ]);
//        }
//
//        $user->token =  $user->createToken($user->name)->plainTextToken;
//
//        return new APIAuthenticationResource($user) ;
//    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Successfully']);
    }


}
