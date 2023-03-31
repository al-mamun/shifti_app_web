<?php

namespace App\Http\Controllers\API\Backend\Store;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductFrontendResource;
use App\Http\Resources\Backend\Store\StoreListForProductCreateResource;
use App\Http\Resources\Backend\Store\StoreResource;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreFollow;
use App\Models\StoreLike;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $stores = Store::latest()->paginate(10);
        return StoreResource::collection($stores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'store_name' =>'required',
            'slug' =>'required|unique:stores',
            'address' =>'required',
            'division_id' =>'required',
            'district_id' =>'required',
            'upazila_id' =>'required',
            'phone' =>'required',
            'email' =>'required',
        ]);

        $data = $request->all();
        $data['slug']= Str::slug($request->input('slug'), '-');
        $store = Store::latest()->first();
        if ($store) {
            $data['slug_id'] = $store->slug_id + 1;
        }else{
            $data['slug_id'] = 100001;
        }
        $data['user_id'] = auth()->user()->id;


        if ($request->exists('logo')) {
            $name = $request->input('slug') . '-' . str_replace([' ', ':'], '-', Carbon::now()).'-logo';
            $path = 'images/uploads/store/';
            $file = $request->input('logo');
            $height = 800;
            $width = 800;
            $data['logo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['logo'] = null;
        }

        if ($request->exists('banner')) {
            $name = $request->input('slug') . '-' . str_replace([' ', ':'], '-', Carbon::now()).'-banner';
            $path = 'images/uploads/store/';
            $file = $request->input('banner');
            $height = 450;
            $width = 1350;
            $data['banner'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['banner'] = null;
        }
        Store::create($data);
        return response()->json(['msg'=>'Store Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return  Store::findOrFail(1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_store_list(): AnonymousResourceCollection
    {
        $stores = Store::orderBy('store_name', 'asc')->get();
        return StoreListForProductCreateResource::collection($stores);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function store_follow_unfollow($id): JsonResponse
    {
        $store_follow = StoreFollow::where('store_id', $id)->where('customer_id', auth()->user()->id)->first();
        if ($store_follow) {
            $store_follow->delete();
            $msg = 'You have successfully unfollowed store';
        }else{
            $data['customer_id'] = auth()->user()->id;
            $data['store_id'] = $id;
            StoreFollow::create($data);
            $msg = 'You have successfully followed store';
        }
        return response()->json(['msg' =>$msg]);
    }

    public function get_store_data($product_slug)
    {
        $product = Product::select('store_id')->where('slug_id', $product_slug)->first();
        if ($product['store_id']) {
            $store_id = $product['store_id'];
        }else{
            $store_id = 1;
        }

        $store = Store::with('follow', 'upazila')->findOrFail($store_id);
        $followed = 0;
        if (auth()->check()) {
            $is_followed = StoreFollow::where('customer_id', auth()->user()->id)->where('store_id', $store_id)->first();
            if ($is_followed) {
                $followed = 1;
            }
        }
        $store_data['id'] = $store->id;
        $store_data['store_name'] = $store->store_name;
        $store_data['upazila']=$store->upazila?->name;
        $store_data['followed']=$followed;
        $store_data['slug']=$store->slug;
        $store_data['slug_id']=$store->slug_id;
        if ($store->follow) {
            $store_data['follow'] = count($store->follow);
        }else{
            $store_data['follow'] = 0;
        }

        return response()->json($store_data);
    }

    public function store_details($id)
    {
        $store = Store::with('follow', 'like')->where('slug_id', $id)->first();
        $is_followed = 0;
        $is_liked = 0;
        if (auth()->check()) {
            $store_follow = StoreFollow::where('store_id', $store->id)->where('customer_id', auth()->user()->id)->first();
            if ($store_follow) {
                $is_followed = 1;
            }
            $store_like = StoreLike::where('store_id', $store->id)->where('customer_id', auth()->user()->id)->first();
            if ($store_like) {
                $is_liked = 1;
            }
        }
        $store_data['id']= $store->id;
        $store_data['store_name']= $store->store_name;
        $store_data['follow']= $store->follow ? $store->follow->count(): 0 ;
        $store_data['like']= $store->follow ? $store->like->count(): 0 ;
        $store_data['about']= $store->about;
        $store_data['is_follow']= $is_followed;
        $store_data['is_liked']= $is_liked;
        $store_data['banner']= $store->banner != null? url('images/uploads/store/'.$store->banner) :  url('images/orpon-bd-banner.png');
        $store_data['logo']= $store->logo != null? url('images/uploads/store/'.$store->logo) :  url('images/orpon-bd-loader.png');
        return response()->json($store_data);
    }

    public function get_store_product($slug_id): AnonymousResourceCollection
    {
        $store = Store::where('slug_id', $slug_id)->first();
        $products = Product::inRandomOrder()->with('review', 'primary_photo', 'productOrderCount')->where('store_id', $store->id)->where('status', 1)->where('parent', null)->where('product_type_id', 1)->paginate(20);
        return ProductFrontendResource::collection($products);
    }

    public function get_store_feature_product(Request $request, $slug_id): AnonymousResourceCollection
    {
        $store = Store::where('slug_id', $slug_id)->first();
        $products = Product::with('review', 'primary_photo', 'productOrderCount')->where('store_id', $store->id)->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        return ProductFrontendResource::collection($products);
    }

    public function get_store_new_arrival_product(Request $request, $slug_id): AnonymousResourceCollection
    {
        $store = Store::where('slug_id', $slug_id)->first();
        $products = Product::latest()->with('review', 'primary_photo', 'productOrderCount')->where('store_id', $store->id)->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        return ProductFrontendResource::collection($products);
    }

    public function get_store_new_product($slug_id): AnonymousResourceCollection
    {
        $store = Store::where('slug_id', $slug_id)->first();
        $products = Product::orderBy('created_at','desc')->with('review', 'primary_photo', 'productOrderCount')->where('store_id', $store->id)->where('status', 1)->where('parent', null)->where('product_type_id', 1)->paginate(20);
        return ProductFrontendResource::collection($products);
    }
}
