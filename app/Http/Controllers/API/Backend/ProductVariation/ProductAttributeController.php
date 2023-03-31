<?php

namespace App\Http\Controllers\API\Backend\ProductVariation;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\AttributeResoruce;
use App\Http\Resources\Backend\Product\ProductAttributeResource;
use App\Http\Resources\Backend\Product\ProductAttributeSuggestionResource;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $attribute = ProductAttribute::orderBy('order_by', 'asc')->get();
        return ProductAttributeResource::collection($attribute);
    }

    public function get_attribute_suggestion()
    {
        $attributes = ProductAttribute::orderBy('order_by', 'asc')->get();
        return ProductAttributeSuggestionResource::collection($attributes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'attribute_name' => 'required|unique:product_attributes',
            'order_by' => 'required',
        ]);

        $data['attribute_name'] = ucfirst($request->attribute_name);
        $data['order_by'] = $request->order_by;
        if($request->status != ""){
            $data['status'] = $request->status;
        }else{
            $data['status'] = 1;
        }
        ProductAttribute::create($data);

        return response()->json([
            'success' => true,
            'msg' => "Attribute Create Successfully"
        ]);

        // $i = 0;
        // $attributes_array = [];
        // while ($request->input('manual_attribute_name_'.$i)){
        //     $old_attribute = ProductAttribute::where('attribute_name', ucwords($request->input('manual_attribute_name_'. $i)))->first();
        //     if (!$old_attribute) {
        //         $data['attribute_name'] = $request->input('manual_attribute_name_'.$i);
        //         $created_attribute =   ProductAttribute::create($data);
        //         $attribute_id = $created_attribute->id;
        //         array_push($attributes_array, $created_attribute->attribute_name);
        //     } else {
        //         $attribute_id = $old_attribute->id;
        //         array_push($attributes_array, $old_attribute->attribute_name);
        //     }
        //     $i++;
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProductAttributeResource
     */
    public function show(int $id): ProductAttributeResource
    {
        $attribute = ProductAttribute::findOrFail($id);
        return  new ProductAttributeResource($attribute);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'attribute_name'  => 'required',
        ]);

        $data['attribute_name'] = ucfirst($request->attribute_name);
        $data['order_by'] = $request->order_by;

        if($request->status != ""){
            $data['status'] = $request->status;
        }else{
            $data['status'] = 1;
        }


       $attribute  = ProductAttribute::findOrFail($id);
       $attribute->update($data);
        return response()->json(['msg'=>'Attribute Updated Successfully']);
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
            $attribute = ProductAttribute::findOrFail($id);
            //log generation start
            $old_data       = $attribute->attribute_name;
            $new_data       = 'Category Deleted';
            $subject        = $attribute->attribute_name. 'Attribute Deleted';
            $column_name    = 'Attribute Deletion';
            $table_name     = (new ProductAttribute())->getTable();
            $action         = 'Deletion';
            Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
            //log generation Ends

            $attribute->delete();
            return response()->json(['msg'=>$attribute->attribute_name.' Attribute Deleted Successfully']);
        }
        catch (ModelNotFoundException)
        {
            return response()->json(['msg'=>'Attribute Not Found']);
        }
    }

    public function status_update(Request $request, $id): JsonResponse
    {
        $attribute= ProductAttribute::findOrFail($id);
        $updated_data = $attribute->update($request->all());
        if ($request->status == 1){
            $status= 'Active';
            $cls = 'success';
        }else{
            $status = 'Inactive';
            $cls = 'warn';
        }
        return response()->json(['msg'=>$attribute->attribute_name.' set as ' . $status, 'cls'=>$cls]);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAttributes(): AnonymousResourceCollection // for product page
    {
        $attribute = ProductAttribute::orderBy('order_by', 'asc')->with('attribute_value')->get();
        return AttributeResoruce::collection($attribute);
    }
}
