<?php

namespace App\Http\Controllers\API\Backend\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreLikeController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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


    public function store_like_unlike($id): JsonResponse
    {
        $store = Store::where('slug_id', $id)->first();
        $store_like = StoreLike::where('store_id', $store->id)->where('customer_id', auth()->user()->id)->first();
        if ($store_like) {
            $store_like->delete();
            $msg = 'You have successfully unliked store';
        }else{
            $data['customer_id'] = auth()->user()->id;
            $data['store_id'] =  $store->id;
            StoreLike::create($data);
            $msg = 'You have successfully liked store';
        }
        return response()->json(['msg' =>$msg]);
    }
}
