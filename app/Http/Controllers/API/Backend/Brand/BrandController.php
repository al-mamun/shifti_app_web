<?php

namespace App\Http\Controllers\API\Backend\Brand;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BrandRequest;
use App\Http\Resources\Backend\BrandResource;
use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if (isset($request->paginate) && $request->paginate != 'null'){
            $pagination  = $request->paginate;
        }else{
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null'){
            $brands = Brand::orderBy('order_by', 'asc')->where('brand_name', 'like', '%'.$request->search.'%')->paginate($pagination);
        }else{
            $brands = Brand::orderBy('order_by', 'asc')->paginate($pagination);
        }
        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return JsonResponse
     */
    public function store(BrandRequest $request)
    {
        $data = $request->all();

        $data['updated_by'] = auth()->user()->id;


        $data['slug']   = Str::of($request->slug)->slug() ;
        $brand_exist_or_not = Brand::all()->count();
        if($brand_exist_or_not > 0){
            $brand = Brand::orderBy('created_at', 'desc')->first();
            $data['slug_id']=$brand->slug_id+1;
        }else{
            $data['slug_id']= 100001;
        }
        $height = 800;
        $width = 800;
        $path = 'images/uploads/brand_logo/';
        $name = $data['slug'].'-'.$data['slug_id'];
        if ($request->logo) {
            $file = $request->logo;
            $data['logo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['logo'] = null;
        }
        if ($request->feature_photo) {
            $height = 530;
            $width = 1650;
            $file = $request->feature_photo;
            $name = $data['slug'].'-'.$data['slug_id'].'-feature-photo';
            $data['feature_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['feature_photo'] = null;
        }
        if ($request->product_photo) {
            $height = 800;
            $width = 800;
            $file = $request->product_photo;
            $name = $data['slug'].'-'.$data['slug_id'].'-product-photo';
            $data['product_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['product_photo'] = null;
        }
        Brand::create($data);
        //log generation start
        $old_data       = 'Brand Created';
        $new_data       =  $request->brand_name;
        $subject        = 'Brand Creation';
        $column_name    = 'Brand Created';
        $table_name     = (new Brand())->getTable();
        $action         = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
        return response()->json(['msg'=>$request->brand_name.' Brand created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BrandResource|JsonResponse
     */
    public function show(int $id): JsonResponse|BrandResource
    {
        try
        {
            $brand = Brand::findOrFail($id);
            return new BrandResource($brand);
        }
        catch (ModelNotFoundException)
        {
            return response()->json(['msg'=>'Brand Not Found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'brand_name'  => ['required'],
            'slug'        => ['required','unique:brands,slug,'.$id],
        ]);
        $data = $request->all();
        $data['slug']   = Str::of($request->slug)->slug() ;
        $brand = Brand::findOrFail($id);
        $original_origin= $brand->getOriginal();    //for log

        $height = 800;
        $width = 800;
        $path = 'images/uploads/brand_logo/';
        $name = $data['slug'].'-'.$brand->slug_id;
        if ($request->logo) {
            $file = $request->logo;
            if ($brand->icon !=null){
                Helper::unlinkImage($path, $brand->icon);
            }
            $data['logo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['logo'] = $brand->logo;
        }

        if ($request->feature_photo) {
            $name = $data['slug'].'-'.$brand->slug_id.'-feature-photo';
            $file = $request->feature_photo;
            if ($brand->feature_photo !=null){
                Helper::unlinkImage($path, $brand->feature_photo);
            }
            $data['feature_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['feature_photo'] = $brand->feature_photo;
        }


        $brand->update($data);
        //log generation start
        $changes        = $brand->getChanges(); //for log
        $old_data = []; //for log
        $new_data = []; //for log
        $subject        = 'Category Update';
        $table_name     = (new Brand())->getTable();

        foreach ($changes as $key=>$value){ //for log
            $old_data[$key] = $original_origin[$key];
            $new_data[$key] = $changes[$key];
            $column_name =$key;
            $action ='Update';
            if ($key !== 'updated_at') {
                Helper::addToLog($subject, $column_name, $old_data[$key], $new_data[$key], $table_name, $action);
            }
        }
        //log generation Ends
        return response()->json(['msg'=>'Brand updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try
        {
            $brand = Brand::findOrFail($id);
            //log generation start
            $old_data       = $brand->brand_name;
            $new_data       = 'Category Deleted';
            $subject        = $brand->brand_name. 'Category Deleted';
            $column_name    = 'Category Deletion';
            $table_name     = (new Brand())->getTable();
            $action         = 'Deletion';
            Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
            //log generation Ends
            $path = 'images/uploads/brand_logo/';
            if ($brand->logo !=null){
                Helper::unlinkImage($path, $brand->logo);
            }
            $brand->delete();
            return response()->json(['msg'=>$brand->brand_name.' Brand Deleted Successfully']);
        }
        catch (ModelNotFoundException)
        {
            return response()->json(['msg'=>'Brand Not Found']);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function status_update(Request $request, $id): JsonResponse
    {
        $brand = Brand::findOrFail($id);
        $updated_data = $brand->update($request->all());
        if ($request->status == 1){
            $status= 'Active';
            $cls = 'success';
        }else{
            $status = 'Inactive';
            $cls = 'warn';
        }
        return response()->json(['msg'=>$brand->brand_name.' set as ' . $status, 'cls'=>$cls]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_brands(): JsonResponse // for product create page
    {
        $brands = Brand::where('status', 1)->orderBy('order_by', 'asc')->get();
        return response()->json($brands);
    }
}
