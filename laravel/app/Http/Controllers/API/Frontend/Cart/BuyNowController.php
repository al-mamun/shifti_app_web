<?php

namespace App\Http\Controllers\API\Frontend\Cart;

use App\Http\Controllers\API\Backend\Cart\CartController;
use App\Http\Controllers\API\Backend\Notification\NotificationController;
use App\Http\Controllers\API\Backend\Order\OrderProductController;
use App\Http\Controllers\API\Backend\Order\ProductOrderCountController;
use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Http\Controllers\API\Frontend\Order\OrderController;
use App\Models\CustomerAddress;
use App\Models\Delivery\DeliveryZone;
use App\Http\Controllers\API\PriceCalculator;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Cart\CartResource;
use App\Mail\OrderConfirmationMail;
use App\Models\Address;
use App\Models\BuyNow;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderVariation;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class BuyNowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function buyNowOrderPlace(Request $request)
    {

        $product = Product::with('parent_product', 'primary_photo')->findOrFail($request->input('product_id'));
        $order_product = new OrderProductController();

            $buyNowCustomerID = BuyNow::where('customer_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->first();

            if(!empty($buyNowCustomerID)) {
                $discount = $buyNowCustomerID->discount; 
            }

            $order_data['customer_address_id'] = $request->input('address_id');
            $order_data['customer_id']         = auth()->user()->id;
            $order_data['order_number']        = OrderController::generate_order_number();
            $order_data['payment_status_id']   = 2;
            $order_data['product_type_id']     = $product->product_type_id;
            $order_data['shipping_method_id']  = 1;
            $order_data['shipping_status_id']  = 1;
            $order_data['track_number']        = OrderController::generate_order_track_number();
             $order_data['sub_total']          = $buyNowCustomerID->sub_total;
            $order_data['delivery_charge']     = $buyNowCustomerID->delivery_charge;
            $order_data['discount']            = $discount;
            $order_data['total_amount']        = $buyNowCustomerID->total_cost;

            $order = Order::create($order_data);

            NotificationController::store($order);

            $order_amount =0;
            if ($product) {

                // $order_product_saved =  $order_product->store($product, $order->id);

                $price_calculator = new PriceCalculator();

                $discount_amount = $price_calculator->discount_amount($product->price, $product->discount_type, $product->discount_amount);
                $discount_price = $price_calculator->discount_price_calculate($product->price, $product->discount_type, $product->discount_amount);

                $product_data['order_id']      = $order->id;
                $product_data['product_id']    = $product->id;
                $product_data['product_name']   = $product->parent == null ? $product->product_name : $product->parent_product?->product_name;
                $product_data['shipping_cost'] = 0;
                $product_data['price'] = $product->price;
                $product_data['discount_price'] = $discount_price;
                $product_data['quantity'] = $request->input('quantity');
                $product_data['product_photo'] = $product->primary_photo?->product_photo;
                $product_data['product_type_id'] = $product->product_type_id;
                $product_data['store_id'] = $product->store_id;
               
                $order_product_saved = OrderProduct::create($product_data);

                ProductOrderCountController::store($product->id, $request->input('quantity'), $product->product_type_id);

                //variations data
                if ($product->parent != null) {
                    $attribute_values = ProductAttributeValue::with('attribute_name')->where('child_product_id', $product->id)->get();

                    foreach ($attribute_values as $attribute_value) {
                        $variation_data['name'] = $attribute_value->attribute_name->attribute_name;
                        $variation_data['value'] = $attribute_value->attribute_value;
                        $variation_data['order_product_id'] = $order_product_saved->id;
                        OrderVariation::create($variation_data);
                    }
                }

                if ($order_product_saved->discount_price != null) {
                    $order_amount+=$order_product_saved->discount_price*$order_product_saved->quantity;
                }else{
                    $order_amount+=$order_product_saved->price*$order_product_saved->quantity;
                }

               $stock_update['stock'] = $product->stock - $request->input('quantity');
                $product->update($stock_update);
            }

            $address_phone = CustomerAddress::where('customer_id', auth()->user()->id)
                ->where('default_address',  1)
                ->orderBy('default_address', 'desc')
                ->first();
           
            if ($address_phone) {
                $phone = $address_phone->phone;
            }else{
                $phone = auth()->user()->phone;
            }

            $message = 'Your Order No.'.$order->order_number.' Successfully Placed. Total Amount ৳'.$order_amount.PHP_EOL.'- Orpon';

            // SMSController::sendSMS($phone, $message);


        $address_phone = CustomerAddress::where('customer_id', auth()->user()->id)
            ->where('default_address',  1)
            ->orderBy('default_address', 'desc')
            ->first();
        
        if ($address_phone && $address_phone->phone != null) {
            $phone = $address_phone->phone;
        }else{
            $phone = auth()->user()->phone;
        }
        if ($address_phone && $address_phone->name != null) {
            $customer_name = $address_phone->name;
        }else{
            $customer_name =  auth()->user()->name;
        }


        $product_for_mail = [];

        array_push($product_for_mail, [
            'product_name'=>$order_product_saved->product_name,
            'quantity'=>$order_product_saved->quantity,
            'image'=> env('API_URL').'/images/uploads/products_thumb/'.$order_product_saved->product_photo,
        ]);



        $details = [
            'name'         => $customer_name,
            'amount'       => $buyNowCustomerID->total_cost,
            'order_number' => $order->order_number,
            'order_url'    => env('APP_URL').'/dashboard-invoice-details/'.$order->order_number,
            'pay_link'     => env('APP_URL').'/dashboard-invoice-details/'.$order->order_number,
            'product'      => $product_for_mail,
        ];

        // Mail::to('naim.iithost@gmail.com')->send(new OrderConfirmationMail($details));

            $data['order_number']      = $order->order_number;
            $data['amount']            = $buyNowCustomerID->total_cost;
            $data['payment_method_id'] = $request->input('payment_method_id');
            return response()->json($data);

    }

    /**
     * [get_buy_now_items description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function get_buy_now_items(Request $request)
    {

        $deliveryCharge = $this->deliveryChargeInfo();

        $buyNowCustomerID = BuyNow::where('customer_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->first();

        $stage = $request->input('stage');

        $discount = 0;
        if(!empty($buyNowCustomerID) && $stage == 2) {
            $discount = $buyNowCustomerID->discount; 
        }

        $product_type = $request->input('product');

        $product = Product::where('id', $product_type['product_id'])
        // ->with(['product_own_variations', 'product_own_variations.attribute_name', 'parent_product', 'primary_photo'])
        ->first();

        $orginalProductPrice = $product->price -  $product->discount_amount;

        $product->quantity       = $product_type['quantity'] ;
        $product->original_price = $product_type['quantity']  *  ($product->price - $product->discount_amount);

     
        if($product->discount_type == 1 ) { // discount type of data

            $product->subTotal       = $product_type['quantity'] *  ($product->price - (($product->price * $product->discount_amount) / 100) );

            $product->totalCostingProduct   =  $product->subTotal + $deliveryCharge - $discount;

            $product->discount   =  $discount;

        } else {

            $product->totalCostingProduct   =  $product_type['quantity'] * ($product->price - $product->discount_amount) + $deliveryCharge -  $discount;

            $product->discount              =  $discount;
            
            $product->subTotal              = $product_type['quantity'] *  ($product->price - $product->discount_amount);
            // ($child_products[0]['price'] * $child_products[0]['discount_amount']) / 100
        }
        
        $product->photo          =  $product->primary_photo != null?  asset('images/uploads/products_thumb/' . $product->primary_photo?->product_photo): asset('images/img_bw.png');
        

        if ($product && $product->parent != null) {
            $parent_product = Product::findOrFail( $product->parent);
            $product->product_name =  $parent_product->product_name;
        }


        return response()->json($product);
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function porccedDiscount(Request $request)
    {

        // Request data setup
        $data = $request->all();
        $buyNowMode = $data['buy_now_mode'];

        if($buyNowMode == 1) {
           $discountStatus = $this->buyNowDisocunt($data);
        } else {
           $discountStatus = $this->cartNowDisocunt($data);
        }
        // Cart summay discount 
        return $discountStatus;
    }

    /**
     * [cartNowDisocunt description]
     * @return [type] [array]
     */
    private function cartNowDisocunt($data ) {

        $deliveryCharge = $this->deliveryChargeInfo();

        $productInfo = $data['product_info'];
        
        $code = ($data['porduct_discount']) ? $data['porduct_discount'] :'';

        $discountAmount = $this->discountCouponInfo($code, $productInfo['subTotal']);

        $discount = array(
            'message'                 => 'Congration you are discount Successfully applied',
            'discount'                => $discountAmount,
            'subTotal'                => intval($productInfo['subTotal']),
            'status'                  => 1,  // discount  found
            'after_discount_total'    => 0,  // discount  found
            'product_type_id'         => intval($productInfo['product_type_id']),  // discount  found
            'quantity'                => intval($productInfo['quantity']),  // discount  found
            'totalAmount'             => intval($productInfo['subTotal']) - $discountAmount + $deliveryCharge,  // discount  found
        );

        return response()->json($discount);
    }

    /**
     * [buyNowDisocunt description]
     * @return [type] [array]
     */
    private function buyNowDisocunt( $data) {

        // buy now discount 
       
        $deliveryCharge = $this->deliveryChargeInfo();

       
        $code = !empty($data['porduct_discount']) ? $data['porduct_discount'] : '';
        $productID = $data['product_info']['product_id'];
        $qty       = $data['product_info']['quantity'];

        // dicount of coupons
        $product = Product::where('id', $productID)->with(['product_own_variations', 'product_own_variations.attribute_name', 'parent_product', 'primary_photo'])->first();

        if($product->discount_type == 1 ) { // discount type of data

          $discountOfProductAmount = (($product->price * $product->discount_amount) / 100);

        } else {
           $discountOfProductAmount = $product->discount_amount;
        }

        $subTotalAmount = $qty * ($product->price - $discountOfProductAmount);

        $discountAmount = $this->discountCouponInfo($code, $subTotalAmount);

        
        // dicount of coupons
        $discount = array(
           'discount'             => $discountAmount,
           'status'               => 1,  // discount  found
           'original_price'       =>  $qty * ($product->price - $discountOfProductAmount),  // discount  found
           'delivery_charge'      =>  $deliveryCharge,  // discount  found
           'sub_total'            =>  $qty * ($product->price - $discountOfProductAmount),  // discount  found
           'totalCostingProduct'  =>  $qty * ($product->price - $discountOfProductAmount) + $deliveryCharge - $discountAmount,  // discount  found
        );
   
        return response()->json($discount);
     
    }

    public function porccedToBuyNowPayment(Request $request) {

        // Request data setup
        $data = $request->all();

        // delivery charg info
        $deliveryCharge = $this->deliveryChargeInfo();

        if($data['buy_now_mode'] == 0) {

            $carts = Cart::where('customer_id', auth()->user()->id)->with('product')->where('selected', 1)->get();

            $quantity             = 0;
            $total                = 0;
            $after_discount_total = 0;
            $product_type_id      = 1;

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

            // $summary['subTotal'] = $total;
            // $summary['discount'] = $total - $after_discount_total;
            // $summary['after_discount_total'] = $after_discount_total;
            // $summary['quantity'] = $quantity;
            // $summary['totalAmount'] = $total +  $deliveryCharge;
            // $summary['totalAmountDeliveryNotCharge'] = $total ;
            // $summary['product_type_id'] = $product_type_id;

            if(!empty($data['porduct_discount'])) { // cart system discount
                $code =  $data['porduct_discount'];
            } else {
                $code =  '';
            }
            
            $discountAmount = $this->discountCouponInfo($code, $total);
            $subTotalAmount      = $total;
            $totalCostingProduct = $total + $deliveryCharge - $discountAmount;

        } else { // direct buy now proceed to pay

             // Coupon table
            $productID = $data['product_info']['product_id'];
            $qty       = $data['product_info']['quantity'];

            if(!empty($data['porduct_discount'])) {

                $code = $data['porduct_discount'];

            } else {
                $code = '';
            }

            $product = Product::where('id', $productID)->with(['product_own_variations', 'product_own_variations.attribute_name', 'parent_product', 'primary_photo'])->first();
            
            if($product->discount_type == 1 ) { // discount type of data
              $discountOfProductAmount = (($product->price * $product->discount_amount) / 100);

            } else {
               $discountOfProductAmount = $product->discount_amount;
            }
            $subTotalAmount = $qty * $product->price - $discountOfProductAmount;

            $discountAmount = $this->discountCouponInfo($code, $subTotalAmount);

            $totalCostingProduct = $subTotalAmount  + $deliveryCharge  - $discountAmount;
             
        }

        $buyNow = new BuyNow();
        $buyNow->customer_id      = auth()->user()->id;
        $buyNow->product_id       = auth()->user()->id;
        $buyNow->code             = $code;
        $buyNow->discount         = $discountAmount;
        $buyNow->sub_total        = $subTotalAmount;
        $buyNow->total_cost       = $totalCostingProduct;
        $buyNow->delivery_charge  = $deliveryCharge;
        $buyNow->save();

        return response()->json($buyNow);

    }

    /**
     * [discountCouponInfo description]
     * @param  [type] $code        [description]
     * @param  [type] $totalAmount [description]
     * @return [type]              [description]
     */
    private function discountCouponInfo($code, $totalAmount) {

        $couponInfo = DB::table('coupons')
            ->where('code', $code)
            ->where('expire_date', '>=', date('Y-m-d'))
            ->first();   

        if(!empty($couponInfo ) && $couponInfo->discount_type == 2) { // fixed discount
            $dicountAmount = $couponInfo->discount_amount;  
        } elseif (!empty($couponInfo ) && $couponInfo->discount_type == 1) { // flat discount
            $dicountAmount = intval((($totalAmount) / 100) * $couponInfo->discount_amount);
        } else {
            $dicountAmount = 0;
        }

        return  $dicountAmount;

    }

    /**
     * [deliverChargeInfo description]
     * @return [type] [description]
     */
    private function deliveryChargeInfo() {

        $addresses = CustomerAddress::where('customer_id', auth()->user()->id)
            ->where('default_address',  1)
            ->orderBy('default_address', 'desc')
            ->first();

        $pivot_data = DB::table('area_delivery_zone')
            ->where('area_id', $addresses->area_id)
            ->first();

        $delivery_charge = DeliveryZone::findOrFail($pivot_data->delivery_zone_id);

        $deliveryCharge = !empty($delivery_charge->delivery_charge) ? $delivery_charge->delivery_charge:0; 
       
        return $deliveryCharge;
    }
}
