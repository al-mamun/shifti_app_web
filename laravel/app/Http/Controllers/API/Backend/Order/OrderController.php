<?php

namespace App\Http\Controllers\API\Backend\Order;

use App\Http\Controllers\API\PriceCalculator;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Order\GroceryOrderListResource;
use App\Http\Resources\Backend\Order\OrderDetailsResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ShippingStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {


        $customers = Customer::get();
        $orderList = Order::with(['customer', 'address','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])
        ->latest()->get();
        // echo"<pre>";
        // print_r($orderList);
        // die();
        return view('admin.order.index',compact('orderList'),[
            'customers' => $customers
        ]);

        // date_default_timezone_set('Asia/Dhaka');

        // $product_type_id = (int) $request->input('product_type_id');
        // $store_id = $request->input('store_id');

        // $status_id = [];
        // if ($request->input('status') != 0) {
        //   $status_id = [$request->input('status')];
        // }else{
        //     $shipping_status = ShippingStatus::all();
        //     foreach ($shipping_status as  $status){
        //         array_push($status_id, $status->id);
        //     }
        // }

        // $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //     $q->where('store_id' , $store_id);
        // })->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);


        // if ($request->input('start_date') != null && $request->input('end_date') != null) {
        //     if ($request->input('start_date') == $request->input('end_date')) {
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereDate('created_at', $request->input('start_date') )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }else{
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereBetween('created_at', [$request->input('start_date').' 00:00:00', $request->input('end_date').' 23:59:00' ] )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }
        // }

        // if ($request->input('filter_by') != 0) {
        //     if ($request->input('filter_by') == 'today') {
        //         $date = Carbon::now()->format('Y-m-d');
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereDate('created_at', $date )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status', 'delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }elseif ($request->input('filter_by') == 'yesterday'){
        //         $date = Carbon::now()->subDay()->format('Y-m-d');
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereDate('created_at', $date )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);

        //     }elseif ($request->input('filter_by') == 'last7'){
        //         $start_date = Carbon::now()->subDay(7)->format('Y-m-d'). ' 00:00:00';
        //         $end_date = Carbon::now()->format('Y-m-d'). ' 23:59:59';
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereBetween('created_at', [$start_date, $end_date] )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }elseif ($request->input('filter_by') == 'last30'){
        //         $start_date = Carbon::now()->subDay(30)->format('Y-m-d'). ' 00:00:00';
        //         $end_date = Carbon::now()->format('Y-m-d'). ' 23:59:59';
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereBetween('created_at', [$start_date, $end_date] )->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }elseif ($request->input('filter_by') == 'thisMonth'){
        //         $date = Carbon::now()->format('m');
        //         $year = Carbon::now()->format('Y');
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereMonth('created_at', $date )->whereYear('created_at', $year)->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }elseif ($request->input('filter_by') == 'lastMonth'){
        //         $date = Carbon::now()->subMonth(1)->format('m');
        //         $year = Carbon::now()->format('Y');
        //         if ($date == 12) {
        //             $year = Carbon::now()->subYear(1)->format('Y');
        //         }
        //         $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //             $q->where('store_id' , $store_id);
        //         })->whereMonth('created_at', $date )->whereYear('created_at', $year)->whereIn('shipping_status_id', $status_id)->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->latest()->where('product_type_id', $product_type_id)->paginate(20);
        //     }
        // }

        // if (strlen($request->input('order_number')) > 0) {
        //     $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //         $q->where('store_id' , $store_id);
        //     })->where('order_number', 'like', '%'.$request->input('order_number').'%')->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->where('product_type_id', $product_type_id)->paginate(20);
        // }

        // if (strlen($request->input('phone')) > 0) {
        //     $orders = Order::whereHas('order_product', function ($q) use ($store_id) {
        //         $q->where('store_id' , $store_id);
        //     })->whereHas('address', function ($q) use ($request) {
        //         $q->where('phone' , 'like', '%'.$request->input('phone').'%');
        //     })->with(['customer', 'address', 'address.city', 'address.zone', 'address.area','order_product', 'shipping_status', 'payment_status','delivery_charge'])->where('product_type_id', $product_type_id)->paginate(20);
        // }

        // return GroceryOrderListResource::collection($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     * @throws Exception
     */
    public function grocery_order_place(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrderDetailsResource
     */
    public function show($id)
    {
         $order = Order::with(['transaction', 'transaction.payment_method','customer', 'order_product', 'address', 'address.city', 'address.zone', 'address.area', 'shipping_status', 'payment_status', 'delivery_charge'])->where('id',$id)->first();

        $orderProduct = $order['order_product'];
       
        return view('admin.order.show',compact('order','orderProduct'));

    }



    public function change_order_status(Request $request)
    {
        $msg ='Something is Going Wrong please Fix';
        if ($request->input('order_id')) {
            $orders = Order::whereIn('id', $request->input('order_id'))->get();
            foreach ($orders as $order){
                $data['shipping_status_id'] = $request->input('shipping_status_id');
                $order->update($data);
            }
            $msg = 'Status Updated Successfully';
        }
        return response()->json(['msg'=>$msg]);
    }

    public function change_single_order_status(Request $request)
    {
        $msg ='Something is Going Wrong please Fix';
        if ($request->input('order_id')) {
            $orders = Order::whereIn('id', $request->input('order_id'))->get();
            foreach ($orders as $order){
                $data['shipping_status_id'] = $request->input('shipping_status_id');
                $order->update($data);
            }
            $msg = 'Status Updated Successfully';
        }
        return response()->json(['msg'=>$msg]);
    }


}
