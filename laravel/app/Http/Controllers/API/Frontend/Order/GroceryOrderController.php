<?php

namespace App\Http\Controllers\API\Frontend\Order;

use App\Http\Controllers\API\Backend\Cart\CartController;
use App\Http\Controllers\API\Backend\Notification\NotificationController;
use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Http\Controllers\API\Frontend\Order\OrderController;
use App\Http\Controllers\API\Backend\Order\OrderProductController;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GroceryOrderController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $address_id = null;
        if ($request->exists('address_id')) {
            $address_id = $request->input('address_id');
        } else {
            $address = Address::where('customer_id', auth()->user()->id)->where('default_address', 1)->first();
            if ($address) {
                $address_id = $address->id;
            } else {
                throw ValidationException::withMessages(['address' => 'Please Select Address']);
            }
        }

        $carts = Cart::with('product')->where('customer_id', auth()->user()->id)->where('product_type_id', 2)->get();
        if (count($carts) > 0) {
            $order_data['address_id'] = $address_id;
            $order_data['customer_id'] = auth()->user()->id;
            $order_data['order_number'] = OrderController::generate_order_number();
            $order_data['payment_status_id'] = 2;
            $order_data['product_type_id'] = 2;
            $order_data['payment_method_id'] = $request->input('payment_method_id');
            $order_data['shipping_method_id'] = 1;
            $order_data['shipping_status_id'] = 1;
            $order_data['track_number'] = OrderController::generate_order_track_number();
            $order = Order::create($order_data);
            NotificationController::store($order);

           $order_product =  new OrderProductController();
            $ordered_product_ids = [];
            $order_amount = 0;
            foreach ($carts as $cart) {
                if ($cart->product) {
                    array_push($ordered_product_ids, $cart->product_id);
                    $order_product_saved =  $order_product->store($cart, $order->id);

                    if ($order_product_saved->discount_price != null) {
                        $order_amount+=$order_product_saved->discount_price*$order_product_saved->quantity;
                    }else{
                        $order_amount+=$order_product_saved->price*$order_product_saved->quantity;
                    }

                    OrderController::product_stock_reducer($cart);
                }
            }
            $address_phone = Address::findOrFail($order->address_id);
            if ($address_phone) {
                $phone = $address_phone->phone;
            }else{
                $phone = auth()->user()->phone;
            }

            $message = 'Your Order No.'.$order->order_number.' Successfully Placed. Total Amount ৳'.$order_amount.PHP_EOL.'- Orpon';

            SMSController::sendSMS($phone, $message);
            CartController::clear_cart_after_order($ordered_product_ids,2);
        }


        if ($request->input('payment_method_id') ==4) {
            $data['order_number'] = $order->order_number;
            $data['amount'] = $order_amount;
            $data['payment_method_id'] = $request->input('payment_method_id');
            return response()->json($data);
        }elseif ($request->input('payment_method_id') ==1){
            $data['order_number'] = $order->order_number;
            $data['amount'] = $order_amount;
            $data['payment_method_id'] = $request->input('payment_method_id');
            return response()->json($data);
        }


        return response()->json(['msg'=>'Order Placed Successfully']);
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
     * @param Request $request
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
