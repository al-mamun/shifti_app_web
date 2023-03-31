<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Product\ChildProductResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ChildProductController extends Controller
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
     * @return ChildProductResource
     */
    public function show(Request $request)
    {
        $attribute_name_id = [];
        $attribute_value = [];
        foreach ($request->variation as $key => $value) {
            $attribute_name_id[] = $key;
            $attribute_value[] = $value;
        }
        $child_products = [];
        for ($i = 0; $i < count($attribute_name_id); $i++) {
            $attribute_name = ProductAttribute::where('attribute_name', $attribute_name_id[$i])->first()->id;
            $child_product = ProductAttributeValue::select('attribute_value', 'child_product_id')->where('product_id', $request->input('product_id'))->where('attribute_value', $attribute_value[$i])->get();
            array_push($child_products, $child_product);
        }

        $child_product_ids = [];
        foreach ($child_products as $child_product) {
            $temp_id = [];
            foreach ($child_product as $child) {
                array_push($temp_id, $child->child_product_id);
            }
            array_push($child_product_ids, $temp_id);
        }
        $result = [];
        if (count($child_product_ids) > 1){
            for($i = 0 ; $i < count($child_product_ids) ; $i++){
                if ($i == 0){
                    $result=  array_intersect($child_product_ids[$i],$child_product_ids[$i+1]);
                }else{
                    $result= array_intersect($result,$child_product_ids[$i]);
                }
            }
        }else{
            $result= $child_product_ids[0];
        }

        $child_product_data = Product::with('product_photos_without_primary', 'primary_photo')->where('id',$result)->first();

        return new ChildProductResource($child_product_data);
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
