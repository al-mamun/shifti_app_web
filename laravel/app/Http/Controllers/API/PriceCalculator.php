<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PriceCalculator extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $price
     * @param $discount_type
     * @param $discount_amount
     * @param null $discount_time
     * @return string|null
     */
    public function discount_price_calculate($price, $discount_type, $discount_amount, $discount_time = null): string|null
    {
        // 1 = percent 2 = flat amount
            if (($discount_time == null || Carbon::now()->lessThanOrEqualTo($discount_time)) && $discount_type != null) {
                if ($discount_type == 1){
                    $price -= ($price * $discount_amount) / 100;
                }elseif ($discount_type == 2){
                    $price -= $discount_amount;
                }
                return round($price);
            }else{
                return null;
            }
    }

    public function discount_amount($price, $discount_type, $discount_amount, $discount_time = null): null|string
    {
        if (($discount_time == null || Carbon::now()->lessThanOrEqualTo($discount_time)) && $discount_type != null) {
            $amount = null;
            if ($discount_type == 1){
                $amount = $discount_amount;
            }elseif ($discount_type == 2){
                $amount = round( $discount_amount *  100 /$price);
            }
            return $amount;
        }
        return  null;
    }


    public function grocery_discount_price_calculate($price, $discount_type, $discount_amount, $discount_time = null): float|int
    {
        // 1 = percent 2 = flat amount
        if (($discount_time == null || Carbon::now()->lessThanOrEqualTo($discount_time)) && $discount_type != null) {
            if ($discount_type == 1){
                $price -= ($price * $discount_amount) / 100;
            }elseif ($discount_type == 2){
                $price -= $discount_amount;
            }
            return round($price);
        }else{
            return $price;
        }
    }

    public function cart_sub_total($price , $quantity): float|int
    {
        return $price*$quantity;
    }

}
