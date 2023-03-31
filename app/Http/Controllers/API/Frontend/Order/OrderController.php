<?php

namespace App\Http\Controllers\API\Frontend\Order;

use App\Http\Controllers\API\Backend\Cart\CartController;
use App\Http\Controllers\API\Backend\Notification\NotificationController;
use App\Http\Controllers\API\Backend\Order\OrderProductController;
use App\Http\Controllers\API\Backend\PaymentMethods\Nagad\NagadController;
use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Order\GlobalOrderListResource;
use App\Http\Resources\Backend\Order\GroceryOrderListResource;
use App\Http\Resources\Backend\Order\OrderDetailsResource;
use App\Jobs\OrderMailJob;
use App\Jobs\SendSMS;
use App\Mail\OrderConfirmationMail;
use App\Models\Address;
use App\Models\BuyNow;
use App\Models\ProductSubscription;
use App\Models\CustomerPackage;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\CustomerShippingAddress;
use App\Models\Delivery\DeliveryZone;
use App\Models\Order;
use App\Models\OrderDeliveryCharge;
use App\Models\PaymentHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Session;
use App\Models\Emailhistory;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $customerID  =  Session::get('customer_id');
        
        $orders = Order::with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])
            ->latest()
            ->where('customer_id', auth()->user()->id)
            ->get();
        
        return GroceryOrderListResource::collection($orders);
    }
    
    public function getMyActivePackage()
    {
        $customerID  =  Session::get('customer_id');
        
        $orders = CustomerPackage::where('customer_id', auth()->user()->id)
            ->leftjoin('subscription_product','customer_package.package_id','subscription_product.id')
            ->orderBy('customer_package.id','desc')
            ->first();
        return json_encode($orders);
        

    }
    
     public function totalOrderAmount()
    {
        $customerID  =  Session::get('customer_id');
        
        $orders = Order::where('orders.customer_id', auth()->user()->id)
            ->leftjoin('order_products','orders.id','=','order_products.order_id')
            ->sum('order_products.price');
        
        return $orders;
    }
    
    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        print_r($amount);
        $stripe = new \Stripe\StripeClient(
            'sk_test_51MQ8LkCmraN7g8Nsj6a6WojRbh10RaI308lVosXRgU15keYKFcaOwGXbIxYeBEv9S8gHZ3WdVR4Kb1qyYM8jNLEj00Xk8iUIby'
        );
        try {
            $charge = $stripe->charges->create([
                'amount' => $amount*100,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }
    
    private function createToken($cardData)
    {
        // $token = null;
        // try {
            $stripe = new \Stripe\StripeClient(
                'pk_test_51MQ8LkCmraN7g8Ns88Z4iC1U8tYWEcvA9HHQV8IkUT1IAaaqJN3FGVsVUlyb9Aqf96DACyM83MVPvgylQ3ntLUtp003RuT6EZI'
            );
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => $cardData->cardNumber,
                    'exp_month' => $cardData->month,
                    'exp_year' => $cardData->year,
                    'cvc' => $cardData->cvv,
                ],
            ]);
        // } catch (CardException $e) {
        //     $token['error'] = $e->getError()->message;
        // } catch (Exception $e) {
        //     $token['error'] = $e->getMessage();
        // }
        return $token;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        
       
        $validator = $request->validate([
            'email'      => 'required|email',
            'fullName'   => 'required',
            'zip_code'   => 'required',
            'address'    => 'required',
            // 'first_name' => 'required',
            'cardNumber' => 'required',
            'month'      => 'required',
            'year'       => 'required',
            'cvv'        => 'required'
        ]);
//  print_r($validator);
//         die();

//         if ($validator->fails()) {
            
//              return response()->json(['message' => 'Validation failed']);
//         }

        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            // $request->session()->flash('danger', $token['error']);
                return response()->json(['message' => 'token generate error']);
        }
        if (empty($token['id'])) {
            // $request->session()->flash('danger', 'Payment failed.');
                return response()->json(['message' => 'Validation failed']);
        }
        
     
        // return response()->redirectTo('/');
            $address_id = null;

            $carts = Cart::with(['product', 'product.primary_photo', 'product.parent_product'])->where('customer_id', auth()->user()->id)->where('status', 0)->get();
            
            $order_amount        = 500;
            
            if(count($carts) == 0) {
                return response()->json(['message' => 'Cart is empty']);
            }
            
            if (count($carts) > 0) {
    
                $get_product_type_id = Cart::where('customer_id', auth()->user()->id)->first();
    
           
                        $carts = Cart::where('customer_id', auth()->user()->id)->with('product')->get();
                        // $carts = Cart::with('product')->where('selected', 1)->get();
                        $quantity             = 0;
                        $total                = 0;
                        $after_discount_total = 0;
                        $product_type_id      = 1;
                         $order_amount        = 0;
                        foreach ($carts as $cart) {
                
                            $product_type_id  = $cart->product_type_id;
                            $quantity         += $cart->quantity;
                            $total            += ($cart->product->price - $cart->product->discount_amount) * $cart->quantity;
                            $temp_after_discount_amount = $cart->product->price;
                
                            if ($cart->product->discount_amount != null) {
                                $temp_after_discount_amount = $cart->product->price - $cart->product->discount_amount;
                            }
                
                            if ($cart->product->discount_percent != null and $cart->product->discount_percent > 0) {
                                $temp_after_discount_amount = $temp_after_discount_amount - ($temp_after_discount_amount * $cart->product->discount_percent) / 100;
                            }
                            $after_discount_total +=  $temp_after_discount_amount * $cart->quantity;
                        }

                    
                    
                    // $summary['subTotal']                     = $total;
                    // $summary['discount']                     = $total - $after_discount_total;
                    // $summary['after_discount_total']         = $after_discount_total;
                    // $summary['quantity']                     = $quantity;
                    // $summary['totalAmount']                  = $total ;
                    // $summary['totalAmountDeliveryNotCharge'] = $total ;
                    // $summary['product_type_id'];
                    $order_data['customer_address_id'] = (int) $address_id;
                    $order_data['customer_id']         = auth()->user()->id;
                    $order_data['order_number']        = OrderController::generate_order_number();
                   
                    $order_data['payment_status_id']   = 2;
                    $order_data['payment_method_id']   = 1;
                    $order_data['product_type_id']     = 1;
                    $order_data['shipping_method_id']  = 1;
                    $order_data['sub_total']           = $total;
                    $order_data['delivery_charge']     = 0;
                    $order_data['discount']            = 0;
                    $order_data['total_amount']        = $total;
                    $order_data['track_number']        = OrderController::generate_order_track_number();
    
                    $order = Order::create($order_data);
    
                    //delivery charge
                    NotificationController::store($order);
    
                    $order_product = new OrderProductController();
                    $ordered_product_ids = [];
                   
                    $product_for_mail    = [];
    
                    foreach ($carts as $cart) {
    
                        if ($cart->product) {
                            array_push($ordered_product_ids, $cart->product_id);
                            $order_product_saved =  $order_product->store($cart, $order->id);
    
                           array_push($product_for_mail, [
                               'product_name'=>$order_product_saved->product_name,
                               'quantity'=>$order_product_saved->quantity,
                               'image'=> env('API_URL').'/images/uploads/products_thumb/'.$order_product_saved->product_photo,
                           ]);
    
                            if ($order_product_saved->discount_price != null) {
                                $order_amount+=$order_product_saved->discount_price*$order_product_saved->quantity;
                            }else{
                                $order_amount+=$order_product_saved->price*$order_product_saved->quantity;
                            }
                            $cartsInfo = Cart::where('customer_id', auth()->user()->id)->where('id', $cart->id)->first();
                            $cartsInfo->status = 1;
                            $cartsInfo->save();
                            OrderController::product_stock_reducer($cart);
                        }
                    }
                    
                    CartController::clear_cart_after_order($ordered_product_ids, 1);
    
             
            }
            
          
            $charge = $this->createCharge($token['id'], $order_amount);
            
            $customerAddress = CustomerAddress::where('customer_id', auth()->user()->id)->first();
            
            if(empty($customerAddress)) {
                
                $customerAddres = new CustomerAddress();
                $customerAddres->name        =  $request->first_name;
                $customerAddres->email       =  $request->email;
                $customerAddres->address     =  $request->address;
                $customerAddres->city_id     =  52;
                $customerAddres->area_id     =  1062;
                $customerAddres->zone_id     =  472;
                $customerAddres->post_code   =  $request->zip_code;
                $customerAddres->country     =  $request->country;
                $customerAddres->city        =  $request->city;
                $customerAddres->customer_id = auth()->user()->id;
                $customerAddres->save();
            } else {
                
                $customerAddressUpdate = CustomerAddress::where('customer_id', auth()->user()->id)->first();
                $customerAddressUpdate->name         = $request->first_name;
                $customerAddressUpdate->email        = $request->email;
                $customerAddressUpdate->address      = $request->address;
                $customerAddressUpdate->city_id      = 52;
                $customerAddressUpdate->area_id      = 1062;
                $customerAddressUpdate->zone_id      = 472;
                $customerAddressUpdate->city         = $request->city;
                $customerAddressUpdate->country      = $request->country;
                $customerAddressUpdate->post_code    = $request->zip_code;
                $customerAddressUpdate->customer_id  = auth()->user()->id;
                $customerAddressUpdate->save();
                
            }
          
            
            if(!empty($charge->id)) {
                
                $paymentInfo = new PaymentHistory();
                $paymentInfo->paymend_id             = $charge->id;
                $paymentInfo->amount                 = $charge->amount;
                $paymentInfo->amount_captured        = $charge->amount_captured;
                $paymentInfo->payment_method         = $charge->payment_method;
                // $paymentInfo->paid                   = $charge->paid;
                $paymentInfo->amount_refunded        = $charge->amount_refunded;
                $paymentInfo->outcome                = json_encode($charge->outcome);
                $paymentInfo->billing_details        = json_encode($charge->billing_details);
                $paymentInfo->payment_method_details = json_encode($charge->payment_method_details);
                $paymentInfo->source                = json_encode($charge->source);
                $paymentInfo->all_status             = json_encode($charge);
                $paymentInfo->status                 = $charge->status;
                $paymentInfo->save();  
                
            }
                
                $data = array('name'=>"Shifti");
                Mail::send('mail', $data, function($message) {
                 $message->to('ratonkumarcse@gmail.com', 'Order Information mail')->subject
                    ('Order Information mail');
                 $message->from('shifti@mamundevstudios.com','Shifti');
                });
            //   $details = [
            //         'name'=> "md Jon",
            //         'amount'=> 200,
            //         'order_number'=> 10000,
            //         'order_url'=> '',
            //         'pay_link'=> '',
            //         'product' => '',
            //         'delivery_charge' => 0
            //     ];

            //     Mail::to('ratonkumarcse@gmail.com')->send(new OrderConfirmationMail($details));
                
            // echo"<pre>";
            //   print_r($charge);
            // die();
            if (!empty($charge) && $charge['status'] == 'succeeded') {
               return response()->json($charge);
            } else {
                return response()->json(['message' => 'Payment failed']);
            }
            $data['order_number'] = $order->order_number;
            $data['amount'] = $order_amount + 0;
            $data['payment_method_id'] =1;
            
            

            return response()->json(['order_number' => 'Order Placed Successfully']);
    }
    
     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function subcriptionPlaceOrder(Request $request)
    {
        
        $validator = $request->validate([
            'email'      => 'required|email',
            'fullName'   => 'required',
            'zip_code'   => 'required',
            'address'    => 'required',
            'cardNumber' => 'required',
            'month'      => 'required',
            'year'       => 'required',
            'cvv'        => 'required'
        ]);


        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            // $request->session()->flash('danger', $token['error']);
                return response()->json(['message' => 'token generate error']);
        }
        if (empty($token['id'])) {
            // $request->session()->flash('danger', 'Payment failed.');
                return response()->json(['message' => 'Validation failed']);
        }
        
     
        // return response()->redirectTo('/');
            $address_id = null;

            $carts = Cart::with(['product', 'product.primary_photo', 'product.parent_product'])
                    ->where('customer_id', auth()->user()->id)
                    ->where('status', 0)
                    ->limit(1)
                    ->latest()
                    ->get();
            
            $order_amount        = 500;
            
            if(count($carts) == 0) {
                return response()->json(['message' => 'Cart is empty']);
            }
            
            if (count($carts) > 0) {
    
                    $get_product_type_id = Cart::where('customer_id', auth()->user()->id)->first();

       
                    $carts = Cart::where('customer_id', auth()->user()->id)
                        ->limit(1)
                        ->with('product')
                        ->limit(1)
                        ->latest()
                        ->get();
                        
                    // $carts = Cart::with('product')->where('selected', 1)->get();
                    $quantity             = 0;
                    $total                = 0;
                    $after_discount_total = 0;
                    $product_type_id      = 1;
                    $order_amount        = 0;
                    
                    foreach ($carts as $cart) {
                        
                        $productSubcraption = ProductSubscription::where('id', $cart->subscriber_id)->first();
                        
                        $product_type_id  = $cart->product_type_id;
                        $quantity         = 1;
                        $total            = $cart->price ;
                        $temp_after_discount_amount = $productSubcraption->price;
                        
                        if ($cart->product->discount_amount != null) {
                            $temp_after_discount_amount = $productSubcraption->price;
                        }
                        
                        if ($cart->product->discount_percent != null and $cart->product->discount_percent > 0) {
                            $temp_after_discount_amount = $temp_after_discount_amount - ($temp_after_discount_amount * $cart->product->discount_percent) / 100;
                        }
                        $after_discount_total =  $temp_after_discount_amount * 1;
                        
                    }


                    $order_data['customer_address_id'] = (int) $address_id;
                    $order_data['customer_id']         = auth()->user()->id;
                    
                    $order_data['order_number']        = OrderController::generate_order_number();
                    $order_data['payment_status_id']   = 2;
                    $order_data['payment_method_id']   = 1;
                    $order_data['product_type_id']     = 1;
                    $order_data['shipping_method_id']  = 1;
                    $order_data['sub_total']           = $total;
                    $order_data['delivery_charge']     = 0;
                    $order_data['discount']            = 0;
                    $order_data['total_amount']        = $total;
                    // $order_data['number_of_employee']  =  $request->number_of_employee;
                    $order_data['track_number']        = OrderController::generate_order_track_number();
    
                    $order = Order::create($order_data);
    
                    //delivery charge
                    NotificationController::store($order);
    
                    $order_product = new OrderProductController();
                    $ordered_product_ids = [];
                   
                    $product_for_mail    = [];
    
                    foreach ($carts as $cart) {
    
                        if ($cart->product) {
                          
                            array_push($ordered_product_ids, $cart->product_id);
                            $order_product_saved =  $order_product->store($cart, $order->id, $cart->subscriber_id, $request->number_of_employee, $cart->price, $cart->service_charge, $cart->user_number);
    
                            array_push($product_for_mail, [
                               'product_name'=>$order_product_saved->product_name,
                               'quantity'=>$order_product_saved->quantity,
                               'image'=> env('API_URL').'/images/uploads/products_thumb/'.$order_product_saved->product_photo,
                            ]);
    
                            $order_amount += $order_product_saved->price * $order_product_saved->quantity + $cart->service_charge;
                            
                            $cartsInfo = Cart::where('customer_id', auth()->user()->id)->where('id', $cart->id)->first();
                            $cartsInfo->status = 1;
                            $cartsInfo->save();
                            
                            $customerPackage = new CustomerPackage();
                            $customerPackage->customer_id    =  auth()->user()->id;
                            $customerPackage->package_id     =  $cart->subscriber_id;
                            $customerPackage->total_amount   =  $order_amount;
                            $customerPackage->service_charge =  $cart->service_charge;
                            $customerPackage->save();
                            
                            OrderController::product_stock_reducer($cart);
                        }
                    }
                    
                    CartController::clear_cart_after_order($ordered_product_ids, 1);
    
             
            }
            
           
            $totalAmountsOrder = intval($order_amount);
            $charge = $this->createCharge($token['id'], $totalAmountsOrder);
      
            $customerAddress = CustomerAddress::where('customer_id', auth()->user()->id)->first();
            
            if(empty($customerAddress)) {
                
                $customerAddres = new CustomerAddress();
                $customerAddres->name        =  $request->first_name;
                $customerAddres->email       =  $request->email;
                $customerAddres->address     =  $request->address;
                $customerAddres->city_id     =  52;
                $customerAddres->area_id     =  1062;
                $customerAddres->zone_id     =  472;
                $customerAddres->post_code   =  $request->zip_code;
                $customerAddres->country     =  $request->country;
                $customerAddres->city        =  $request->city;
                $customerAddres->customer_id = auth()->user()->id;
                $customerAddres->save();
                
            } else {
                
                $customerAddressUpdate = CustomerAddress::where('customer_id', auth()->user()->id)->first();
                $customerAddressUpdate->name         = $request->first_name;
                $customerAddressUpdate->email        = $request->email;
                $customerAddressUpdate->address      = $request->address;
                $customerAddressUpdate->city_id      = 52;
                $customerAddressUpdate->area_id      = 1062;
                $customerAddressUpdate->zone_id      = 472;
                $customerAddressUpdate->city         = $request->city;
                $customerAddressUpdate->country      = $request->country;
                $customerAddressUpdate->post_code    = $request->zip_code;
                $customerAddressUpdate->customer_id  = auth()->user()->id;
                $customerAddressUpdate->save();
                
            }
            
            $customerShippingAddressExistCheck = CustomerShippingAddress::where('customer_id', auth()->user()->id)->first();
            
            $shippingEmail     = $request->shipping_email;
            $shippingAddress   = $request->shipping_address;
            $shippingCity      = $request->shipping_city;
            $shippingZip       = $request->shipping_zip_code;
            $shippingCountry   = $request->shipping_country;
            $shippingPhone     = $request->phone;
            
            if(!empty($request->is_bill_address)) {
                $shippingEmail    = $request->email;
                $shippingAddress  = $request->shipping_address;
                $shippingCity     = $request->city;
                $shippingZip      = $request->zip_code;
                $shippingCountry  = $request->shipping_country;
                $shippingPhone    = $request->shipping_phone;
            }
            
            if(!empty($customerShippingAddressExistCheck)) {

                $customerShippingAddressUpdate = CustomerShippingAddress::where('customer_id', auth()->user()->id)->first();
                $customerShippingAddressUpdate->email        = $shippingEmail;
                $customerShippingAddressUpdate->address      = $shippingAddress;
                $customerShippingAddressUpdate->city         = $shippingCity;
                $customerShippingAddressUpdate->country      = $shippingCountry;
                $customerShippingAddressUpdate->phone_number  = $shippingPhone;
                $customerShippingAddressUpdate->zip_code     = $shippingZip;
                $customerShippingAddressUpdate->save();
                
            } else {
                
                $customerShippingAddressSave = new CustomerShippingAddress();
                $customerShippingAddressSave->customer_id = auth()->user()->id;
                $customerShippingAddressSave->email        = $shippingEmail;
                $customerShippingAddressSave->address      = $shippingAddress;
                $customerShippingAddressSave->city         = $shippingCity;
                $customerShippingAddressSave->country      = $shippingCountry;
                $customerShippingAddressSave->zip_code     = $shippingZip;
                $customerShippingAddressSave->phone_number  = $shippingPhone;
                $customerShippingAddressSave->customer_id  = auth()->user()->id;
                $customerShippingAddressSave->save();
                
            }
            
            if(!empty($charge->id)) {
                
                $paymentInfo = new PaymentHistory();
                $paymentInfo->paymend_id             = $charge->id;
                $paymentInfo->amount                 = $charge->amount;
                $paymentInfo->amount_captured        = $charge->amount_captured;
                $paymentInfo->payment_method         = $charge->payment_method;
                // $paymentInfo->paid                   = $charge->paid;
                $paymentInfo->amount_refunded        = $charge->amount_refunded;
                $paymentInfo->outcome                = json_encode($charge->outcome);
                $paymentInfo->billing_details        = json_encode($charge->billing_details);
                $paymentInfo->payment_method_details = json_encode($charge->payment_method_details);
                $paymentInfo->source                 = json_encode($charge->source);
                $paymentInfo->all_status             = json_encode($charge);
                $paymentInfo->status                 = $charge->status;
                $paymentInfo->save();  
                
                
            }
            
            $title = 'Order Confrimation '. $order->order_number;
            
            $data = array(
                'name'               => $request->fullName, 
                'type'               => "Order Confirmation", 
                'message'            => $request->fullName, 
                'TotalAmount'        => $order_amount, 
                'serviceFee'         => $request->fullName,
                'numberOfEomployee'  => $request->fullName, 
                'email'              => $request->email,
                'job_title'          => $title,
                'email_title'        => $title,
            );
             Mail::send(['html' => 'mail'], compact('data'), function($message) use ($data) {
                 
            // Mail::send('mail', $data, function($message) {
             $message->to($data['email'], 'Order Confirmation mail')->subject
                ('Order Information mail');
             $message->from('shifti@mamundevstudios.com','Shifti');
            });
            
            Emailhistory::emailSendList($request->fullName,  $title, '',  1, $order->order_number, '', $request->email);// 1 Purchaase type
        
            if (!empty($charge) && $charge['status'] == 'succeeded') {
               return response()->json($charge);
            } else {
                return response()->json(['message' => 'Payment failed']);
            }
            $data['order_number']      = $order->order_number;
            $data['amount']            = $order_amount + 0;
            $data['payment_method_id'] = 1;
            
            

            return response()->json(['order_number' => 'Order Placed Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return OrderDetailsResource
     */
    public function show(int $id): OrderDetailsResource
    {
        $order = Order::with(['customer', 'order_product', 'address', 'address.city', 'address.zone', 'address.area', 'shipping_status', 'payment_status', 'delivery_charge'])->where('customer_id', auth()->user()->id)->where('order_number',$id)->first();
        return new OrderDetailsResource($order);
    }

    /**
     * @return AnonymousResourceCollection
     */

    public function global_order_list(): AnonymousResourceCollection
    {
        $orders = Order::with(['global_order_product', 'shipping_status', 'payment_status'])->latest()->where('product_type_id', 3)->where('customer_id', auth()->user()->id)->get();
        return GlobalOrderListResource::collection($orders);
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

    /**
     * @return int
     */
    public static function generate_order_number(): int
    {
        $order_number = null;
        $order = Order::orderBy('order_number', 'desc')->first();
        if ($order) {
            $order_number = $order->order_number + 1;
        } else {
            $order_number = 1000001;
        }
        return $order_number;
    }

    /**
     * @return string|void
     * @throws Exception
     */
    public static function generate_order_track_number()
    {
        $track_number = random_int(1000000000, 9999999999);
        $track_number = md5($track_number);
        $track_number = strtoupper($track_number);
        $track_number = substr($track_number, 0, 13);
        $order = Order::where('track_number', $track_number)->first();
        if ($order) {
            self::generate_order_track_number();
        } else {
            return $track_number;
        }
    }

    public static function product_stock_reducer($cart)
    {
        $product_data['stock'] = $cart->product?->stock - $cart->quantity;
        $cart->product?->update($product_data);
    }
}
