<?php

namespace App\Http\Controllers\API\Backend\Slider;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Slider\SliderResource;
use App\Models\Banner;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $sliders  = Slider::orderBy('order_by')->get();
        return  SliderResource::collection($sliders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
           // 'slider_photo'   => 'required',
            'status'         => 'required',
        ]);
        $data['updated_by'] = auth()->user()->id;
        $data = $request->except('slider_photo');
        if ($request->slider_photo) {
            $name = $request->location.'-'.str_replace([' ', ':'], '-', Carbon::now() );
            $path = 'images/uploads/sliders/';
            $file = $request->slider_photo;
            $height = 360;
            $width = 930;
            $data['slider_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['slider_photo'] = null;
        }
        $banner = Slider::create($data);
        return  response()->json(['msg'=>'Slider Created Successfully']);


        return response()->json([
            'status'=> 200,
            'message'=>'Slider Added Successfully!',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $slider = Slider::with('admin')->findOrFail($id);
            return  new SliderResource($slider);
        }catch(ModelNotFoundException){
            return  response()->json( ['msg'=> 'Data Not Found']);
        }
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
        $this->validate($request, [
            'status'         => 'required',
            'title'         => 'required',
            'link'         => 'required',
            'order_by'         => 'required',
        ]);

        $height = 360;
        $width = 930;


        $slider = Slider::findOrFail($id);

        $data = $request->except('slider_photo');
        $data['updated_by'] = auth()->user()->id;
        if ($request->slider_photo) {
            $name = $request->location . '-' . str_replace([' ', ':'], '-', Carbon::now());
            $path = 'images/uploads/sliders/';
            $file = $request->slider_photo;
            $data['slider_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['slider_photo'] = $slider->slider_photo;
        }
        $slider->update($data);
        return  response()->json(['msg' => 'Slider Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $path = 'images/uploads/sliders/';
            if( $slider->slider_photo != null){
                Helper::unlinkImage($path, $slider->slider_photo);
            }
            $slider->delete();
            return response()->json(['msg'=>'Slider Deleted successfully']);
        }catch(ModelNotFoundException){
            return  response()->json( ['msg'=> 'Data Not Found']);
        }
    }


}
