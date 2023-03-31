<?php

namespace App\Http\Controllers\API\Backend\Product;

use any;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductAddPageGalleryResource;
use App\Http\Resources\Backend\Product\ProductAddpagePreviewResource;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\ProductVideo;
use App\Models\TemporaryPhoto;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductPhotoController extends Controller
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
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->file) {

            $product = Product::findOrFail($request->id);
            $name = $product->slug.rand(10000,99999);
            $height = 800;
            $width = 800;
            $path = 'images/uploads/products/';
            $height_thumb = 150;
            $width_thumb = 150;
            $path_thumb = 'images/uploads/product_thumbs/';

            $product_photo = $request->file;
            Helper::uploadImage($name, $height_thumb, $width_thumb, $path_thumb, $product_photo);
            $photo['product_photo'] = Helper::uploadImage($name, $height, $width, $path, $product_photo);
            $photo['product_id'] = $product->id;
            ProductPhoto::create($photo);
        }
        
        return response()->json(['msg'=>'Success']);
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
     * @param  Request  $request
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $photo = ProductPhoto::findOrFail($id);
            $path = 'images/uploads/products/';
            $path_thumb = 'images/uploads/products_thumb/';
            Helper::unlinkImage($path,$photo->product_photo);
            Helper::unlinkImage($path_thumb,$photo->product_photo);
            $photo->delete();
            return response()->json(['msg'=>'Image Deleted successfully']);
        }catch(ModelNotFoundException){
            return  response()->json( ['msg'=> 'Data Not Found']);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public function upload_product_photo(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $path = 'images/uploads/products/';
        $path_thumb = 'images/uploads/products_thumb/';

        $primary_photo = ProductPhoto::where('product_id', $request->product_id)->where('primary', 1)->first();
        if (!$primary_photo){
            if ($request->feature_photo){
                $rand= rand(1000, 99999);
                $name = $product->slug.'-'.$product->slug_id.'-'.$rand;
                Helper::uploadImage($name, 250, 250, $path_thumb, $request->feature_photo);
                $photo['product_photo'] = Helper::uploadImage($name, 800, 800, $path, $request->feature_photo);
                $photo['primary'] = 1;
                $photo['product_id'] = $request->product_id;
                ProductPhoto::create($photo);
                $photo=[];
                $name=[];
            }
        }

        if ($request->photo_gallery) {
            foreach ($request->photo_gallery as $photos){
                $photo['primary'] = 0;
                $rand= rand(1000, 99999);
                $name = $product->slug.'-'.$product->slug_id.'-'.$rand;
                Helper::uploadImage($name, 250, 250, $path_thumb, $photos);
                $photo['product_photo'] = Helper::uploadImage($name, 800, 800, $path, $photos);
                $photo['product_id']=$request->product_id;
                ProductPhoto::create($photo);
                $photo=[];
                $name=[];
            }
        }
        $product_photos  = ProductPhoto::where('product_id', $request->product_id)->get();
        return  ProductAddPageGalleryResource::collection($product_photos);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function get_photos_for_preview($id){

        $product_photos  = ProductPhoto::where('product_id', $id)->orderBy('primary', 'desc')->get();
        return  ProductAddPageGalleryResource::collection($product_photos);
    }

    public function update_primary_photo($id, Request $request)
    {
        $video = ProductVideo::where('product_id', $request->product_id)->first();
        if ($video){
            $video->delete();
        }
        $photos = ProductPhoto::where('product_id', $request->product_id)->get();
        foreach ($photos as $photo){
            $data['primary'] = 0;
            $photo->update($data);
        }
        $primary_photo = ProductPhoto::findOrFail($id);
        $data['primary']= 1;
        $primary_photo->update($data);
        return response()->json(['msg'=>'Primary Photo set successfully']);
    }

}
