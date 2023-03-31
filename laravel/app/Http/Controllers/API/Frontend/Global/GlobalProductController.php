<?php

namespace App\Http\Controllers\API\Frontend\Global;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Global\GlobalCategoryListResource;
use App\Http\Resources\Frontend\Grocery\GroceryCategoryProductListResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GlobalProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
       // $products = Category::with(['grocery_product', 'grocery_product.primary_photo'])->where('product_type_id', 3)->orderBy('order_by', 'asc')->where('status', 1)->where('parent', null)->get();
        $global_category = Category::where('parent', 2)->with('grocery_product', 'grocery_product.primary_photo')->orderBy('order_by', 'asc')->where('status', 1)->get();

        return GroceryCategoryProductListResource::collection($global_category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return AnonymousResourceCollection
     */
    public function get_global_products_for_index(): AnonymousResourceCollection
    {
        $categories = Category::whereIn('id',[98, 97,102, 100])->with(['globalProduct', 'globalProduct.primary_photo'])->get();
        return GlobalCategoryListResource::collection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
}
