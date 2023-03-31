<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\API\PriceCalculator;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductPhoto;
use App\Models\ProductVariation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_product_variation_data(Request $request)
    {

        return $request->all();
    }

    /**
     * @param $id
     * @return null[]|string[]
     */

    function get_variation_product_price($id)
    {
        $final_price = null;
        $discount_price = null;
        $discount_amount = null;

        $product = Product::findOrFail($id);
        if ($product) {//if product exists
            if ($product->variation_product == 1) {//if product is variation product
                $child_products = Product::select('id', 'price', 'discount_type', 'discount_amount', 'discount_time')->where('status', 1)->where('parent', $id)->where('price', '!=', null)->orderBy('price', 'asc')->get()->toArray();
                $final_price = null;
                if (count($child_products) > 0) { //if child product exist
                    if (count($child_products) > 2) {//if child product more than 2 then get lowest and highest
                        $lowest_price = array_shift($child_products);
                        $highest_price = array_pop($child_products);
                        $final_price = '৳ ' . number_format($lowest_price['price'], 2) . ' - ' . '৳ ' . number_format($highest_price['price'], 2); //final price if variations

                        $temp_discount = null;
                        if ($lowest_price['discount_time'] != null && $lowest_price['discount_amount'] != null && $lowest_price['discount_type'] != null && Carbon::create($lowest_price['discount_time'])->addDay()->greaterThanOrEqualTo(Carbon::now())) {

                        }

                    } else { // if variation product but child is not more than 2
                        $final_price = '৳ ' . number_format($child_products[0]['price']);
                    }
                }
            }

        }

        return ['original_price' => $final_price, 'discount_price' => $discount_price, 'discount_amount' => $discount_amount];
    }


    public function get_variation_product_price_backup($id)
    {
        $child_products = Product::select('id', 'price', 'discount_type', 'discount_amount', 'discount_time')->where('status', 1)->where('parent', $id)->where('price', '!=', null)->orderBy('price', 'asc')->get()->toArray();
        $final_price = null;
        $discount_price = null;
        $discount_amount = null;
        $discount_price_lowest = null;
        $discount_price_highest = null;
        $price_calculator = new PriceCalculator();

        if (count($child_products) > 0) {
            if (count($child_products) >= 2) {
                $lowest_price = array_shift($child_products);
                $highest_price = array_pop($child_products);

                if ($lowest_price['price'] != $highest_price['price']) {
                    $final_price = '৳ ' . number_format($lowest_price['price'], 2) . ' - ' . '৳ ' . number_format($highest_price['price'], 2);
                    $discount_price_lowest = $price_calculator->discount_price_calculate($lowest_price['price'], $lowest_price['discount_type'], $lowest_price['discount_amount']);
                    $discount_price_highest = $price_calculator->discount_price_calculate($highest_price['price'], $highest_price['discount_type'], $highest_price['discount_amount']);
                } else {
                    $final_price = '৳ ' . number_format($lowest_price['price']);
                    $discount_price_lowest = $price_calculator->discount_price_calculate($lowest_price['price'], $lowest_price['discount_type'], $lowest_price['discount_amount']);
                }
            } else {
                $final_price = '৳ ' . number_format($child_products[0]['price']);
                $discount_price_lowest = $price_calculator->discount_price_calculate($child_products[0]['price'], $child_products[0]['discount_type'], $child_products[0]['discount_amount']);
            }
        }
        $discount_price_array = [];
        if ($discount_price_lowest != null && $discount_price_highest != null) {
            array_push($discount_price_array, $discount_price_lowest);
            array_push($discount_price_array, $discount_price_highest);

            asort($discount_price_array);
            $discount_price = '৳ ' . $discount_price_array[0] . ' - ' . '৳ ' . $discount_price_array[1];
        }

        return ['original_price' => $final_price, 'discount_price' => $discount_price];
    }


    public function get_variation_data($id = null)
    {
        $attributes_values = ProductAttributeValue::select('attribute_value', 'product_attribute_id', 'id')->with('attribute_name')->where('product_id', $id)->groupBy('attribute_value')->get();

        $attribute_name_id = [];
        foreach ($attributes_values as $attributes_value) {
            if (!in_array($attributes_value->product_attribute_id, $attribute_name_id)) {
                array_push($attribute_name_id, $attributes_value->product_attribute_id);
            }
        }
        $attribute_name = [];
        foreach ($attribute_name_id as $name_id) {
            $attribute = ProductAttribute::findOrFail($name_id);
            $temp = ['id' => $name_id, 'name' => $attribute->attribute_name];
            array_push($attribute_name, $temp);
        }
        $formatted_data = [];
        for ($i = 0; $i < count($attribute_name); $i++) {
            $temporary_data = [];
            foreach ($attributes_values as $attributes_value) {
                if ($attributes_value->product_attribute_id == $attribute_name_id[$i]) {
                    array_push($temporary_data,[$attributes_value->id , $attributes_value->attribute_value]);
                }
            }
            $temp_name = ['name' => $attribute_name[$i]['name']];
            $temp_array = ['name' => $attribute_name[$i]['name'], 'value' => array_reverse($temporary_data) ];
            array_push($formatted_data, $temp_array);
        }

        return $formatted_data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_color_variation_photos($id)
    {
        $color_id = ProductAttribute::where('attribute_name', 'Color')->first()->id;

        $variation_products = ProductAttributeValue::select('attribute_value', 'child_product_id')->where('product_id', $id)->where('product_attribute_id', $color_id)->get();

        $attribute_value = [];
        $photos = [];
        foreach ($variation_products as $variation_product) {
            if (!in_array($variation_product->attribute_value, $attribute_value)) {
                array_push($attribute_value, $variation_product->attribute_value);
                $photo = ProductPhoto::where('product_id', $variation_product->child_product_id)->where('primary', 1)->first();
                if ($photo) {
                    array_push($photos, ['name' => $variation_product->attribute_value, 'photo' => url('images/uploads/products_thumb') . '/' . $photo->product_photo]);
                } else {
                    array_push($photos, ['name'=>  $variation_product->attribute_value]);
                }
            }
        }
        return $photos;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function calculate_price_for_frontend_product_list($id)
    {
        date_default_timezone_set("Asia/Dhaka");
        $final_price = null;
        $discount_price = null;
        $discount_amount = null;

        $product = Product::findOrFail($id);
        if ($product) {//if product exists
            if ($product->variation_product == 1) {//if product is variation product
                $child_products = Product::select('id', 'price', 'discount_type', 'discount_amount', 'discount_time')->where('status', 1)->where('parent', $id)->where('price', '!=', null)->orderBy('price', 'asc')->get()->toArray();
                $final_price = null;
                if (count($child_products) >= 1) { //if child product has variation
                    $lowest_price = array_shift($child_products);
                    $final_price = '৳ ' . $lowest_price['price']; //final price if variations

                    $temp_lowest_discount = null;
                    if ($lowest_price['discount_time'] == null || Carbon::create($lowest_price['discount_time'])->greaterThanOrEqualTo(Carbon::now()->startOfDay())) {
                        if ($lowest_price['discount_amount'] != null && $lowest_price['discount_type'] != null) {
                            $temp_lowest_discount = $lowest_price['price'];
                            if ($lowest_price['discount_type'] == 1) {
                                $temp_lowest_discount -= ($lowest_price['price'] * $lowest_price['discount_amount']) / 100;
                                $discount_amount = number_format($lowest_price['discount_amount'], 2).'%';
                            } elseif ($lowest_price['discount_type'] == 2) {
                                $temp_lowest_discount -= $lowest_price['discount_amount'];
                                $discount_amount = number_format( $lowest_price['discount_amount'] * 100 /  $lowest_price['price'], 2).'%';
                            }
                            $discount_price =  '৳ ' .$temp_lowest_discount;

                        }
                    }
                } else { // if variation product but child is not more than 2
                    $final_price = '৳ ' .$product->price;
                }
            }else{
                $final_price = '৳ ' .$product->price;

                if ($product->discount_type != null && Carbon::create($product->discount_time)->greaterThanOrEqualTo(Carbon::now()->startOfDay())) {
                    if ($product->discount_type  == 1) {
                        $discount_price ='৳ ' . ($product->price * $product->discount_amount) / 100;
                        $discount_amount = number_format($product->discount_amount).'%';
                    }else if($product->discount_type  == 2){
                        $discount_price = '৳ ' .$product->discount_amount;
                        $discount_amount = number_format($product->discount_amount * 100 /  $product->price, 2).'%' ;
                    }
                }
            }

        }

        return ['original_price' => $final_price, 'discount_price' => $discount_price, 'discount_amount' => $discount_amount];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
