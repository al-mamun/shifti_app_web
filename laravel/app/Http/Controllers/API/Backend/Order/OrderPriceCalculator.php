<?php

namespace App\Http\Controllers\API\Backend\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderPriceCalculator extends Controller
{
    public static function calculate_total_price($order_products): array
    {
        $amount_after_discount = 0;
        $total_amount = 0;
        $discount = 0;

        foreach ($order_products as $order_product) {

            $total_amount+=$order_product->price * $order_product->quantity;

            if ($order_product->discount_price == null) {

                $amount_after_discount+=$order_product->price * $order_product->quantity;

            }else{

                $amount_after_discount+=$order_product->discount_price * $order_product->quantity;
                $discount+=($order_product->price-$order_product->discount_price) * $order_product->quantity;
            }
        }



        return ['amount_after_discount'=>$amount_after_discount, 'discount'=>$discount, 'total_amount'=>$total_amount];
    }

    public  static function calcualte_due_amount($order_number)
    {
        $order = Order::with('order_product', 'transaction')->where('order_number', $order_number)->first();
        if ($order && count($order->order_product) > 0) {

            $amount_after_discount = 0;
            $total_amount = 0;
            $discount = 0;

            foreach ($order->order_product as $order_product){

                $total_amount+=$order_product->price * $order_product->quantity;

                if ($order_product->discount_price == null) {

                    $amount_after_discount+=$order_product->price * $order_product->quantity;

                }else{

                    $amount_after_discount+=$order_product->discount_price * $order_product->quantity;
                    $discount+=($order_product->price-$order_product->discount_price) * $order_product->quantity;
                }
            }

            $transactions = $order->transaction;
            $paid_amount = 0;
            if (count($transactions) > 0) {
                foreach ($transactions as $transaction){
                    $paid_amount+=$transaction->amount;
                }
            }
            $due_amount = $amount_after_discount-$paid_amount;

            return [
                'amount_after_discount'=>$amount_after_discount,
                'discount'=>$discount,
                'total_amount'=>$total_amount,
                'due_amount' =>$due_amount,
                'paid_amount' =>$paid_amount,
            ];

        }
    }

}
