<?php

namespace App\Http\Controllers\API\Backend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Customer\CustomerResource;
use App\Http\Resources\Backend\Order\GroceryOrderListResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Auth;
use AuthenticatesUsers;
use Session;

class DashboardController extends Controller
{
   
     public function loginCustom(Request $request)
    {
  
        $username  = $request->get('email');
        $password  = $request->get('password');
        
        $remember_me = $request->has('remember_me') ? true : false;
        $userData    = [ 'email' =>  $username,'password' => $request->input('password') ];
        
     
        if( Auth::attempt( $userData, $remember_me ) ) {
            

            Session::put('session_key', 'value');
            $user   = Auth::User();
          
            return Redirect('admin/dashboard');

        } else {
            Auth::logout();
            return redirect('/login')->with([
                'status' => 1,
                'error' => "Your user role isn't assigned. You can't login. Please contact to PCB.",
            ]);
        }
    }
    public function dashboard() {
        
        $todayTotalVisiting = 100;
        $total_sale = OrderProduct::all()->sum('price');
        $todaySale  = OrderProduct::wherebetween ('created_at',[date('Y-m-d'),' 00:00:00',date('Y-m-d'),' 23:59:59' ])->sum('price');
        
        $orders = Order::with(['customer', 'address','order_product', 'shipping_status', 'payment_status'])->latest()
            ->limit(5)
            ->get();
        
        $productInfo = Product::latest()
            ->limit(5)
            ->get();
         
         $totalProduct = Product::count();
            
        return view('admin.dashboard.index',[
            'todaySale'           => $todaySale,
            'totalProduct'        => $totalProduct,
            'todayTotalVisiting'  => $todayTotalVisiting,
            'total_sale'          => $total_sale,
            'orders'              => $orders,
            'productInfo'         => $productInfo,
            'todaySale'           => $todaySale,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::all()->count();
        $total_sale = OrderProduct::all()->sum('price');
        $user = Customer::all()->count();
        $general_order = Order::where('product_type_id', 1)->count();
        $grocery_order = Order::where('product_type_id', 2)->count();
        $global_order = Order::where('product_type_id', 3)->count();
        
        $statistics = [
            'orders' => $orders,
            'total_sale' => $total_sale,
            'user' => $user,
            'general_order' => $general_order,
            'grocery_order' => $grocery_order,
            'global_order' => $global_order,
        ];
       return response()->json($statistics);
    }

    /**
     * @return AnonymousResourceCollection
     */

    public function get_new_user(): AnonymousResourceCollection
    {
        $users = Customer::latest()->take(5)->get();
        return CustomerResource::collection($users);
    }

    public function get_recent_orders(): AnonymousResourceCollection
    {
        $orders = Order::with(['customer', 'address', 'address.division', 'address.district', 'address.upazila','order_product', 'shipping_status', 'payment_status'])->latest()->where('product_type_id', 1)->get();
        return GroceryOrderListResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
