<?php

namespace App\Http\Controllers\API\Frontend\Wishlist;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductFrontendResource;
use App\Http\Resources\Frontend\Wishlist\FrontWishlistListResource;
use App\Models\WishList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrontendWishListController extends Controller
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
     */
    public function store(Request $request): JsonResponse
    {
        $my_wishlist = WishList::where('product_id', $request->input('product_id'))->where('customer_id', auth()->user()->id)->first();
        if ($my_wishlist) {
            $my_wishlist->delete();
            return response()->json(['msg'=>'Product removed from Wishlist']);
        }else{
            $data['product_id'] =  $request->input('product_id');
            $data['customer_id'] = auth()->user()->id;
            $data['status'] = 1;
            WishList::create($data);
            return response()->json(['msg'=>'Product Added to Wishlist']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_wishlist_details(Request $request): JsonResponse
    {
        $wishlist_count = WishList::where('product_id', $request->input('product_id'))->count();
        $my_wishlist = false;
        if ( auth()->user()) {
            $my_wishlist = WishList::where('product_id', $request->input('product_id'))->where('customer_id', auth()->user()->id)->first();
        }
        $details = ['count'=>$wishlist_count, 'my_wishList'=> (bool) $my_wishlist];
        return response()->json($details);
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $wishlist = WishList::findOrFail($id);
        $wishlist->delete();
        return response()->json(['msg'=>'Wishlist Product Removed Successfully']);
    }

    public function get_my_wishlist()
    {
        $wishlist = WishList::with(['product', 'product.primary_photo'])->where('customer_id', auth()->user()->id)->get();
        return FrontWishlistListResource::collection($wishlist);
    }
}
