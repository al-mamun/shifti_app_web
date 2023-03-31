<?php

namespace App\Http\Controllers\API\Backend\Review;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReplay;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewReplayController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        if ($request->hasFile('replay_photo')) {
            $file = $request->file('replay_photo');
            $dimensions = getimagesize($file);
            $height = $dimensions[1];
            $width = $dimensions[0];
            $path = 'images/uploads/product_review/';
            $name= $name = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $data['replay_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['replay_photo'] = null;
        }
        $data['user_id']    = Auth::user()->id??1;
        $data['status']     = 0;
        ReviewReplay::create($data);
        return response()->json(['msg'=>'Your review replay successfully sent']);
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
     * @param Request $request
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
