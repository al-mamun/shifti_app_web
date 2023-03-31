<?php

namespace App\Http\Controllers\API\Backend\ProductVariation;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductAttributeValueResource;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductAttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $attribute_value = ProductAttributeValue::orderBy('order_by', 'asc')->with('attribute_name')->get();
        return ProductAttributeValueResource::collection($attribute_value);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
       $this->validate($request, [
           'status'     => 'required',
           'attribute_value'    => 'required|max:255',
           'product_attribute_id'   =>'required',
       ]);
        $product_attribute_value = ProductAttributeValue::create($request->all());
       return response()->json(['msg'=>$product_attribute_value->attribute_value.' Attribute Value created Successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProductAttributeValueResource
     */
    public function show(int $id): ProductAttributeValueResource
    {
        $product_value = ProductAttributeValue::findOrFail($id);
        return new ProductAttributeValueResource($product_value);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'status'     => 'required',
            'attribute_value'    => 'required|max:255',
            'product_attribute_id'   =>'required',
        ]);
        $value['attribute_value'] = $request->attribute_value;
        $value['order_by'] = $request->order_by;
        $value['product_attribute_id'] = $request->product_attribute_id;
        $value['status'] = $request->status;

        $old_value = ProductAttributeValue::findOrFail($id);
        $old_value->update($value);
        return response()->json(['msg'=>'Attribute Value Updated Successfully']);
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
            $attribute = ProductAttributeValue::findOrFail($id);
            //log generation start
            $old_data       = $attribute->attribute_name;
            $new_data       = 'Attribute value';
            $subject        = $attribute->attribute_name. 'Attribute Value Deleted';
            $column_name    = 'Attribute Value Deletion';
            $table_name     = (new ProductAttributeValue())->getTable();
            $action         = 'Deletion';
            Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
            //log generation Ends

            $attribute->delete();
            return response()->json(['msg'=>$attribute->attribute_value.' Attribute Value Deleted Successfully']);
        }
        catch (ModelNotFoundException)
        {
            return response()->json(['msg'=>'Attribute Not Found']);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function status_update(Request $request, int $id): JsonResponse
    {
        $attribute= ProductAttributeValue::findOrFail($id);
        $updated_data = $attribute->update($request->all());
        if ($request->status == 1){
            $status= 'Active';
            $cls = 'success';
        }else{
            $status = 'Inactive';
            $cls = 'warn';
        }
        return response()->json(['msg'=>$attribute->attribute_value.' set as ' . $status, 'cls'=>$cls]);
    }


}
