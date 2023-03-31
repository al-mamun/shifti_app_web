<?php

namespace App\Http\Controllers\API\Backend\Order;

use App\Http\Controllers\API\PriceCalculator;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\OrderVariation;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Response;

class OrderProductController extends Controller
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
     * @param $product
     * @param $order_id
     */
    public function store($product, $order_id,$subcraptionID, $number_of_emoloyee, $price,$service_charge,$numberOfEmployee)
    {
        $price_calculator = new PriceCalculator();

        $discount_amount = $price_calculator->discount_amount($product->product?->price, $product->product?->discount_type, $product->product?->discount_amount);
        $discount_price = $price_calculator->discount_price_calculate($product->product?->price, $product->product?->discount_type, $product->product?->discount_amount);

        $product_data['order_id']          = $order_id;
        $product_data['product_id']        = $product->product?->id;
        $product_data['subscriber_id']     = $subcraptionID;
        $product_data['product_name']      = $product->product?->parent == null ? $product->product?->product_name : $product->product?->parent_product?->product_name;
        $product_data['shipping_cost']     = 0;
        $product_data['price']             = $price;
        $product_data['service_charge']    = $service_charge;
        $product_data['discount_price']    = $discount_price;
        $product_data['quantity']          = $product->quantity;
        $product_data['product_photo']     = $product->product?->primary_photo?->product_photo;
        $product_data['product_type_id']   = $product->product_type_id;
        $product_data['user_number']       = $numberOfEmployee;
        $product_data['store_id'] = $product->product?->store_id;
        $order_product = OrderProduct::create($product_data);

        ProductOrderCountController::store($product->product->id, $product->quantity, $product->product_type_id);

        //variations data
        if ($product->product?->parent != null) {
            $attribute_values = ProductAttributeValue::with('attribute_name')->where('child_product_id', $product->product?->id)->get();

            foreach ($attribute_values as $attribute_value) {
                $variation_data['name'] = $attribute_value->attribute_name->attribute_name;
                $variation_data['value'] = $attribute_value->attribute_value;
                $variation_data['order_product_id'] = $order_product->id;
                OrderVariation::create($variation_data);
            }
        }
        return $order_product;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($product_id)
    {
        
      
        $order_product = OrderProduct::where('product_id', $product_id)->delete();
        // $order_product->delete();
        return Response::json(['status' => 200]);
    }
    
    
     public function cartDestory(Request $request)
    {
        
        $cart_id = $request->get('cart_id');
  
        $order_product = Cart::where('id', $cart_id)->delete();
        // $order_product->delete();
        return Response::json(['status' => 200]);
    }
    
}
