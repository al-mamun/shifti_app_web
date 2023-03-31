<?php

namespace App\Http\Controllers\API\Frontend\Grocery;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Grocery\GroceryCategoryListResource;
use App\Http\Resources\Frontend\Grocery\GroceryCategoryProductListResource;
use App\Http\Resources\Frontend\Grocery\GroceryProductDetailsForModal;
use App\Http\Resources\Frontend\Grocery\GroceryProductListCategoryWiseResource;
use App\Http\Resources\Frontend\Grocery\GroceryProductListResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroceryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $category = Category::where('slug_id', $request->input('slug_id'))->first();
        $data = $category->all_grocery_product()->orderBy($request->input('order_by'), $request->input('order_direction'))->paginate($request->input('take'));
        return GroceryProductListResource::collection($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_grocery_category_for_products_page(Request $request): JsonResponse
    {
        $category = Category::select('category_name', 'id')->where('slug_id', $request->input('slug_id'))->first();
        return response()->json($category);
    }


    /**
     * @return AnonymousResourceCollection
     */

    public function get_grocery_category(): AnonymousResourceCollection
    {
        $categories = Category::where('product_type_id', 2)->orderBy('order_by', 'asc')->where('status', 1)->where('parent', null)->get();
        return GroceryCategoryListResource::collection($categories);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function get_grocery_products()
    {
        $products = Category::with(['grocery_product','grocery_product.productOrderCount', 'grocery_product.primary_photo'])->where('product_type_id', 2)->orderBy('order_by', 'asc')->where('status', 1)->where('parent', null)->get();
        return GroceryCategoryProductListResource::collection($products);
    }

    /**
     * @param Request $request
     * @return GroceryProductDetailsForModal
     */
    public function get_modal_product(Request $request): GroceryProductDetailsForModal
    {
        $product = Product::with('primary_photo', 'product_photo')->findOrFail($request->id);
        return new GroceryProductDetailsForModal($product);
    }

    /**
     * @param Request $request
     * @return GroceryProductDetailsForModal
     */
    public function get_grocery_product_details(Request $request): GroceryProductDetailsForModal
    {
        $product = Product::with('primary_photo', 'product_photo', 'review')->where('slug_id',$request->id)->first();
        return new GroceryProductDetailsForModal($product);
    }
}
