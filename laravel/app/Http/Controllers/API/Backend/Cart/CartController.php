<?php

namespace App\Http\Controllers\API\Backend\Cart;

use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Cart\CartProductVariationResrouce;
use App\Http\Resources\Frontend\Cart\CartResource;
use App\Models\BuyNow;
use App\Models\ProductSubscription;
use App\Models\Cart;
use App\Models\CartVariation;
use App\Models\CustomerAddress;
use App\Models\Delivery\DeliveryZone;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use DB;
use Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $session = Session::get('customer_id');
  
        if ($request->exists('product_type_id')) {
            
            $carts = Cart::where('customer_id', auth()->user()->id)->where('product_type_id', $request->input('product_type_id'))->with(['product','product.product_own_variations', 'product.product_own_variations.attribute_name', 'product.parent_product', 'product.primary_photo'])->get();
            
        } else{
            
            $carts = Cart::where('customer_id', auth()->user()->id)->with(['product','product.product_own_variations', 'product.product_own_variations.attribute_name', 'product.parent_product', 'product.primary_photo'])->get();
            
        }
        return CartResource::collection($carts);
    }

    /**
     * @return JsonResponse
     */
    public function cart_items_count(): JsonResponse
    {
        $cart_count = Cart::where('customer_id', auth()->user()->id)->count();
        return response()->json(['count'=>$cart_count]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {

        $this->validate($request, [
            'product_id' => 'required',
    
        ]);
        
        $customer_id = Session::get('token');
        print_r($customer_id);
        if(!empty($customer_id)) {
            $cart_exits = Cart::where('customer_id', $customer_id)->where('product_id', $request->input('product_id'))->first();
            if ($cart_exits) {
//                if ($request->input('product_type_id') == 2) {
                    $total_quantity =  $cart_exits->quantity + $request->input('quantity');
                    $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
                    if ($product['stock'] >= $total_quantity ) {
                        $cart['quantity'] =$total_quantity;
                    }else{
                        throw ValidationException::withMessages(['msg'=>'Sorry Product Stock out!']);
                    }

//                }else{
//                    $cart['quantity'] = $cart_exits->quantity + 1;
//                }
                $cart_exits->update($cart);
                return response()->json(['msg' => 'Cart Updated Successfully']);
            } else{
                
                $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
                if ($product['stock'] >= $request->input('quantity')) {
                    
                    $cart['customer_id']     = $customer_id;
                    $cart['product_id']      = $request->input('product_id');
                    $cart['quantity']        = $request->input('quantity');
                    $cart['product_type_id'] = $request->input('product_type_id');
                    $saved_cart = Cart::create($cart);
                    return response()->json(['msg' => 'Product Added to Cart Successfully']);
                }else{
                    throw ValidationException::withMessages(['msg'=>'Sorry Product Stock out!','statu'=>0]);
                }
            }
        } else{
            return response()->json(['msg' => 'Sorry Unauthorized Activity Detected!','status' => 0]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function get_cart_product_variations(int $id)
    {

        $child_product = Product::findOrFail($id);

        $variation_object =  new ProductVariationController();
        $price_object = new PriceCalculatorController();
        $price = $price_object->calculate_price($child_product->parent);
        $variation = $variation_object->get_variation_data($child_product->parent);
        $color_photos = null;
        foreach ($variation as $data){
            if(in_array('Color', $data)){
                $color_photos =  $variation_object->get_color_variation_photos($child_product->parent);
                break;
            }
        }
        $output_data =  ['color_photos'=>$color_photos, 'variation'=> $variation];

      return response()->json($output_data);
//      //  return  $variation;
//        return CartProductVariationResrouce::collection($variation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|null
     */
    public function update(Request $request, int $id)
    {
        if(empty($id)){
             return response()->json(['msg' => 'You Can\'t Add More Than Stock Item']);
        }
        $cart = Cart::findOrFail($id);
        if(empty($cart)){
             return response()->json(['msg' => 'You Can\'t Add More Than Stock Item']);
        }
        if ($request->type == 'decrease') {
            if ($cart->quantity > 1) {
                $cart_data['quantity'] = $cart->quantity - 1;
                $cart->update($cart_data);
                 return response()->json(['msg' => 'Successfuly updated','status'=>200]);
            } else {
                return response()->json(['msg' => 'Quantity Must Not be less Than One']);
            }
        } elseif ($request->type == 'increase') {
            
            $product = Product::findOrFail($cart->product_id);
            $cart_data['quantity'] = $cart->quantity + 1;
            $cart->update($cart_data);
            return response()->json(['msg' => 'Successfuly updated','status'=>200]);
           
        } elseif ($request->type == 'number') {
           
            $cart_data['quantity'] = $request->quantity;
            $cart->update($cart_data);
             return response()->json(['msg' => 'Successfuly updated','status'=>200]);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return response()->json(['msg' => 'Item Removed Successfully']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update_cart_attributes(Request $request): JsonResponse
    {
        foreach ($request->all() as $variation) {
            $data = [];
            $data['attribute_name'] = $variation['attribute_name'];
            $data['attribute_value'] = $variation['attribute_value'];
            $variation_database = CartVariation::findOrFail($variation['id']);
            $variation_database->update($data);
        }
        return response()->json(['msg' => 'success']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function handle_cart_select(int $id)
    {
        $cart = Cart::findOrFail($id);
        if ((int) $cart->selected != 1) {
            $data['selected'] = 1;
        } else {
            $data['selected'] = 0;
        }
        $cart->update($data);
       // return 'hello';
        $select_data['selected']= 0;

        if ($cart->product_type_id == 1) {
            $other_carts = Cart::whereIn('product_type_id', [2,3])->where('customer_id', auth()->user()->id)->get();
            foreach ($other_carts as $other_cart){
                $other_cart->update($select_data);
            }
        }elseif ($cart->product_type_id == 2){
            $other_carts = Cart::whereIn('product_type_id', [1,3])->where('customer_id', auth()->user()->id)->get();
            foreach ($other_carts as $other_cart){
                $other_cart->update($select_data);
            }
        }elseif ($cart->product_type_id == 3){
            $other_carts = Cart::whereIn('product_type_id', [1,2])->where('customer_id', auth()->user()->id)->get();
            foreach ($other_carts as $other_cart){
                $other_cart->update($select_data);
            }
        }

        return response()->json(['msg' => 'success']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function  handle_cart_all_select(Request $request)
    {

        $carts = Cart::where('customer_id', auth()->user()->id)->where('product_type_id', $request->input('product-type-id'))->get();
        $data['selected'] = $request->input('checked');
        foreach ($carts as $cart){
            $cart->update($data);
        }
        return response()->json(['msg' => 'success']);
    }

    /**
     * @return array
     */
    public function get_cart_summary(Request $request): array
    {

        $carts = Cart::where('customer_id', auth()->user()->id)
            ->where('type', 1)
            ->with('product')
            ->get();
            
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

        $summary['subTotal']                     = $total;
        $summary['discount']                     = $total - $after_discount_total;
        $summary['after_discount_total']         = $after_discount_total;
        $summary['quantity']                     = $quantity;
        $summary['totalAmount']                  = $total ;
        $summary['totalAmountDeliveryNotCharge'] = $total ;
        $summary['product_type_id']              = $product_type_id;

        return $summary;
    }

     /**
     * @return array
     */
    public function subcraption_get_cart_summary(Request $request): array
    {

        $carts = Cart::where('customer_id', auth()->user()->id)
            ->where('type', 2)
            ->with('product')
            ->limit(1)
            ->latest()
            ->get();
            
        $quantity             = 0;
        $total                = 0;
        $after_discount_total = 0;
        $product_type_id      = 1;

        foreach ($carts as $cart) {
            
             $productSubcraption = ProductSubscription::where('id', $cart->subscriber_id)->first();
            
            $product_type_id  = $cart->product_type_id;
            $quantity         = 1;
            $total            = ($productSubcraption->price ) * 1;
            $temp_after_discount_amount = $productSubcraption->price;

            if ($cart->product->discount_amount != null) {
                $temp_after_discount_amount = $productSubcraption->price;
            }

            if ($cart->product->discount_percent != null and $cart->product->discount_percent > 0) {
                $temp_after_discount_amount = $temp_after_discount_amount - ($temp_after_discount_amount * $cart->product->discount_percent) / 100;
            }
            $after_discount_total =  $temp_after_discount_amount * 1;
        }

        $summary['subTotal']                     = $total;
        $summary['discount']                     = $total - $after_discount_total;
        $summary['after_discount_total']         = $after_discount_total;
        $summary['quantity']                     = $quantity;
        $summary['totalAmount']                  = $total ;
        $summary['totalAmountDeliveryNotCharge'] = $total ;
        $summary['product_type_id']              = $product_type_id;

        return $summary;
    }
    
    public static function clear_cart_after_order($ordered_product_ids, $product_type_id)
    {
        $carts = Cart::where('customer_id', auth()->user()->id)->where('product_type_id', $product_type_id)->get();
        foreach ($carts as $cart){
            if (in_array($cart->product_id, $ordered_product_ids)) {
                $cart->delete();
            }
        }
    }

    public function global_order_list()
    {
        $carts = Cart::whereIn('product_type_id', [1,3])->get()->count();
        
        // $carts = Cart::where('customer_id', auth()->user()->id)->whereIn('product_type_id', [1,3])->get()->count();
        return response()->json(['cart_count'=>$carts]);
    }

}
