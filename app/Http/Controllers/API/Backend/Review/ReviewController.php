<?php

namespace App\Http\Controllers\API\Backend\Review;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('review_photo')) {
            $file = $request->file('review_photo');
            $dimensions = getimagesize($file);
            $height = $dimensions[1];
            $width = $dimensions[0];
            $path = 'images/uploads/product_review/';
            $name= $name = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $data['review_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['review_photo'] = null;
        }
        $data['user_id']    = Auth::user()->id??1;
        $data['star'] = $request->star??5;
        $data['status']     = 0;
        Review::create($data);
        return response()->json(['msg'=>'Your review successfully Saved']);
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
}
