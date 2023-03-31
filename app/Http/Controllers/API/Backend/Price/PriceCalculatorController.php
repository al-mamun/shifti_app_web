<?php

namespace App\Http\Controllers\API\Backend\Price;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PriceCalculatorController extends Controller
{
    /**
     * @param $id
     * @return null[]|string[]
     */
    function calculate_price($id)
    {
     //   date_default_timezone_set("Asia/Dhaka");
        $final_price = null;
        $discount_price = null;
        $discount_amount = null;

        $product = Product::findOrFail($id);
        if ($product) {//if product exists
          
            if ($product->variation_product == 1) {//if product is variation product
                $child_products = Product::select('id', 'price', 'discount_type', 'discount_amount', 'discount_time')->where('status', 1)->where('parent', $id)->where('price', '!=', null)->orderBy('price', 'asc')->get()->toArray();
                $child_products1 = Product::select('id', 'price', 'discount_type', 'discount_amount', 'discount_time')->where('status', 1)->where('parent', $id)->where('price', '!=', null)->orderBy('price', 'asc')->get()->toArray();
               
                $final_price = null;
                if (count($child_products) > 0) { //if child product exist

                    if (count($child_products) >= 2) {//if child product more than 2 then get lowest and highest

                        $lowest_price = array_shift($child_products);
                        $highest_price = array_pop($child_products);

                        if ($lowest_price['price'] != $highest_price['price']) {

                            $final_price = ceil($lowest_price['price']) . ' - '  . ceil($highest_price['price']); //final price if variations

                            $temp_lowest_discount = null;

                            if ($lowest_price['discount_time'] == null || Carbon::create($lowest_price['discount_time'])->greaterThanOrEqualTo(Carbon::now()->startOfDay())){
                                if ($lowest_price['discount_amount'] != null && $lowest_price['discount_type'] != null) {
                                    $temp_lowest_discount = $lowest_price['price'];
                                    if ($lowest_price['discount_type'] == 1) {
                                        $temp_lowest_discount -= ($lowest_price['price'] * $lowest_price['discount_amount']) / 100;
                                    } elseif ($lowest_price['discount_type'] == 2) {
                                        $temp_lowest_discount -= $lowest_price['discount_amount'];
                                    }
                                }
                            }



                            $temp_highest_discount = null;

                            if ($highest_price['discount_time'] == null || Carbon::create($highest_price['discount_time'])->greaterThanOrEqualTo(Carbon::now()->startOfDay())) {
                                if ($highest_price['discount_amount'] != null && $highest_price['discount_type'] != null) {
                                    $temp_highest_discount = $highest_price['price'];
                                    if ($highest_price['discount_type'] == 1) {
                                        $temp_highest_discount -= ($highest_price['price'] * $highest_price['discount_amount']) / 100;
                                        $discount_amount = ceil($highest_price['discount_amount']) . '% OFF';
                                    } elseif ($highest_price['discount_type'] == 2) {
                                        $temp_highest_discount -= $highest_price['discount_amount'];
                                        $discount_amount_temp = ($highest_price['discount_amount'] / $highest_price['price']) * 100;
                                        $discount_amount = ceil($discount_amount_temp)  . '% OFF';
                                    }
                                }
                            }



                            if ($temp_lowest_discount != null && $temp_highest_discount != null) {
                                $discount_price = ceil($temp_lowest_discount) . ' - ' . '' . ceil($temp_highest_discount);
                            } else {
                                if ($temp_lowest_discount != null) {
                                    $discount_price = ceil($temp_lowest_discount) . ' - ' . '' . ceil($highest_price['price']);
                                } else {
                                    $discount_price = ceil($lowest_price['price']) . ' - ' . '' . ceil($temp_highest_discount);
                                }
                            }


                        } else {
                            
                            if(!empty($child_products1[0])) {

                                $final_price = ceil($child_products1[0]['price']);

                                $lowest_price = $child_products1;
    
                                if ($child_products1[0]['discount_type'] == 1) {
    
                                    $discount_amount = $child_products1[0]['discount_amount']. '% OFF';
                                    $discount_price = ($child_products1[0]['price'] * $child_products1[0]['discount_amount']) / 100;
    
                                } elseif ($child_products1[0]['discount_type']  == 2) {
    
                                    $discount_price =  ceil(($child_products1[0]['price']) - $child_products1[0]['discount_amount']);
    
    
                                    $discount_amount  =   ceil(($discount_price * 100) / $child_products1[0]['price']) ;
                                    $discount_amount  =   100 - $discount_amount  .'% OFF';
                                }

                                $discount_price =  ceil($child_products1[0]['price']) - $discount_price;  

                            }  else {
                                
                                $final_price = ceil($lowest_price['price']);

                                if ($lowest_price['discount_time'] != null && $lowest_price['discount_amount'] != null && $lowest_price['discount_type'] != null && Carbon::create($lowest_price['discount_time'])->addDay()->greaterThanOrEqualTo(Carbon::now())) {
                                    $discount_price = $lowest_price['price'];
                                    if ($lowest_price['discount_type'] == 1) {
                                        $discount_price -= ($lowest_price['price'] * $lowest_price['discount_amount']) / 100;
                                        $discount_amount = $lowest_price['discount_amount']. '% OFF';
                                    } elseif ($lowest_price['discount_type'] == 2) {
                                        $discount_price -= $lowest_price['discount_amount'];
                                        $discount_amount = $lowest_price['discount_amount']. ' OFF';
                                    }
                                    $discount_price =  '' .ceil($discount_price);
                                }
                            }
                            
                        }



                    } else { // if variation product but child is not more than 2


                        $final_price = '' . ceil($child_products[0]['price']);

                        $lowest_price = $child_products;

                            if ($child_products[0]['discount_type'] == 1) {

                                $discount_amount = ($child_products[0]['price'] * $child_products[0]['discount_amount']) / 100;
                                $discount_price = $child_products[0]['discount_amount']. '% OFF';

                            } elseif ($child_products[0]['discount_type']  == 2) {

                                $discount_price =  ceil($child_products[0]['price']) - $child_products[0]['discount_amount'];


                                $discount_amount  =   ceil(($discount_price * 100) / $child_products[0]['price']) ;
                                $discount_amount  =   100 - $discount_amount  .'% OFF';
                            }
                             $discount_price =  '' .ceil($discount_price);

                       
                    }
                }

            } else { //if it's single product

                $final_price = '' . ceil($product->price);
                if ($product->discount_time == null || Carbon::create($product->discount_time)->greaterThanOrEqualTo(Carbon::now()->startOfDay())){
                    if ($product->discount_amount != null && $product->discount_type != null) {
                        $discount_price = $product->price;
                        if ($product->discount_type == 1){
                            $discount_price -= ($product->price * $product->discount_amount) / 100;
                            $discount_amount = $product->discount_amount.'% OFF';
                        }elseif ($product->discount_type == 2){
                            $discount_price -= $product->discount_amount;
                            $temp_discount_amount = ($product->discount_amount/ $product->price) * 100;
                            $discount_amount =   ceil($temp_discount_amount) .'% OFF';
                        }
                        $discount_price =  ''.ceil($discount_price);
                    }
                }
            }
            return ['original_price' => $final_price, 'discount_price' => $discount_price, 'discount_amount' => $discount_amount];

        }
    }

    public function product_cost_calculator($id)
    {
        $product_cost = 0;

        $product = Product::findOrFail($id);
        if ($product) { //if product exist
            if ($product->variation_product == 1 ) { //if product is variation
                $child_products = Product::select('parent', 'id' , 'product_cost' )->where('parent', $id)->whereNotNull('product_cost')->orderBy('product_cost', 'asc')->get()->toArray();
                if (count($child_products) >= 2) {//if product is more than two
                    $lowest = array_shift($child_products);
                    $highest = array_pop($child_products);
                    if ($lowest['product_cost'] ==$highest['product_cost']) {
                        $product_cost =  ''.ceil($lowest['product_cost']);
                    }else{
                       $product_cost =  ''.ceil($lowest['product_cost']). ' - ' .''.ceil($highest['product_cost']);
                    }

                }else{
                    if (isset($child_products[0])){
                        $product_cost = ''.ceil($child_products[0]['product_cost']);
                    }else{
                        $product_cost = null;
                    }

                }
            }else{
                $product_cost =  ''.ceil($product['product_cost']);
            }
        }
        return $product_cost;
    }
}
