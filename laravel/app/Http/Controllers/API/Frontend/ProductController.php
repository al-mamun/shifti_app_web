<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductDetailsResource;
use App\Http\Resources\Backend\Product\ProductFrontendResource;
use App\Http\Resources\Backend\Product\ProductSortingResource;
use App\Http\Resources\Frontend\OrderCountProduct\OrderCountProductResource;
use App\Http\Resources\Frontend\Product\ProductDetailsForSingleProductResource;
use App\Http\Resources\Frontend\Product\ProductDetailsForVariationProductResource;
use App\Http\Resources\Frontend\Product\ProductSearchResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductOrderCount;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'discount_percent' => 'required',
            'price' => 'required',
            'product_cost' => 'required',
            'product_name' => 'required|max:255',
            'product_type_id' => 'required',
            'sku' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'stock' => 'required',
        ]);

        $product['description'] = $request->description;
        $product['discount_percent'] = $request->discount_percent;
        $product['feature_photo'] = $request->feature_photo;
        $product['price'] = $request->price;
        $product['product_name'] = $request->product_name;
        $product['product_type_id'] = $request->product_type_id;
        $product['sku'] = $request->sku;
        $product['slug'] = $request->slug;
        $product['status'] = $request->status;
        $product['stock'] = $request->stock;


    }

    /**
     * @param Request $request
     * @return ProductDetailsForSingleProductResource|ProductDetailsForVariationProductResource|JsonResponse
     */
    public function show(Request $request)
    {
        $product = Product::with('store', 'store.upazila', 'video', 'productOrderCount', 'country', 'product_photo', 'product_specifications', 'delivery_information', 'seo', 'category', 'tag', 'brand', 'faq', 'primary_photo')->where('slug_id', $request->slug_id)->first();

        if ($product && $product->variation_product == 1) {
            return new ProductDetailsForVariationProductResource($product);
        }
        return new ProductDetailsForSingleProductResource($product);
    }

    /**
     * @param $product_id
     * @param $take
     * @return JsonResponse
     */
    public function get_recommended_product($product_id, $take): JsonResponse
    {
        try {
            $product = Product::with('tag')->where('slug_id', $product_id)->first();
            $searchWords = [];
//            foreach ($product->tag as $tag){
//                $searchWords[] = $tag->tag_name;
//            }
            if ($searchWords) {
                $product = Product::query();
                foreach ($searchWords as $word) {
                    $product->whereHas('tag', function ($query) use ($word) {
                        $query->orWhere('tag_name', 'LIKE', '%' . $word . '%')->with('product');
                    });
                }
                $tags = $product->distinct()->limit($take)->orderBy('created_at', 'desc')->get();
                return response()->json(
                    [
                        'data' => $tags,
                        'status' => 200
                    ]
                );
            } else {
                return response()->json(
                    [
                        'msg' => 'Product Not Found',
                        'status' => 404
                    ]
                );
            }
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'msg' => 'Product Not Found',
                    'status' => 404
                ]
            );
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get_recommended_product_right(Request $request): JsonResponse
    {
        $product_id = $request->product_id;
        return $this->get_recommended_product($product_id, 3);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function get_recommended_product_bottom(Request $request): JsonResponse
    {
        $product_id = $request->product_id;
        return $this->get_recommended_product($product_id, 10);
    }

    public function get_categories(): JsonResponse
    {
        $categories = Category::orderBy('order_by')->get();
        
        if ($categories) {
            $categoryArray = [];

            foreach( $categories as $catInfo) {
    
                $categoryArray[] =[
                    'ID'              => $catInfo->id,
                    'category_name'   => $catInfo->category_name,
                    'slug'            => $catInfo->slug,
                    'icon'            => asset('images/uploads/category_icon/'.$catInfo->icon)
                    
                ];
            }
            return response()->json($categoryArray);
         
        } else {
            return response()->json([
                'msg' => 'Not found',
                'status' => 404,
            ]);
        }
    }


    public function get_category_product(Request $request)
    {

//        $category = Category::with('category_with_all_child')->where('slug_id',$request->slug_id)->first();
//
//        $index = $category->category_with_all_child;
//
//        $child_id = [];
//        while ($index) {
//            if ($index->category_with_all_child) {
//                $child_id[] = $index->category_with_all_child->id;
//            }
//            $index = $index->category_with_all_child;
//        }


        $child_categories = $this->get_all_child_category($request->slug_id);

        $query = Product::with('category', 'primary_photo')->whereHas('category', function ($q) use ($child_categories) {
            $q->whereIn('slug_id', $child_categories);
        })->where('parent', null)->orderBy($request->input('sortBy'), $request->input('sortByDirection'));

        if ($request->input('maxPrice') != null) {

            $query = Product::with('category', 'primary_photo')->whereHas('category', function ($q) use ($child_categories) {
                $q->whereIn('slug_id', $child_categories);
            })->whereHas('child_product_filter', function ($n) use ($request) {
                $n->where('price', '>=' , $request->input('maxPrice'));
            })->where('parent', null)->orderBy($request->input('sortBy'), $request->input('sortByDirection'));

            $query->orWhere('price', '>=' , $request->input('maxPrice'))->where('parent', null);
        }
        if ($request->input('stock') == 'in-stock') {
            $query->where('stock' , '>', 0);
        }else if($request->input('stock') == 'stock-out'){
            $query->where('stock' ,  0)->orWhere('stock' ,  null);
        }
        $products = $query->paginate(24);
     //   $product_collection = ProductSortingResource::collection($products);
      //  $product_collection = $product_collection->sortBy('price')->all();
        return  ProductFrontendResource::collection($products);

    }

    /**
     * @param $slug_id
     * @return array
     */
    public function get_all_child_category($slug_id): array
    {
        $category = Category::with('category_with_all_child')->where('slug_id', $slug_id)->first();
        $child_categories = [];
        if ($category->category_with_all_child) {
            foreach ($category->category_with_all_child as $sub_category){
                $child_categories[]= $sub_category->slug_id;
                if ($sub_category->category_with_all_child) {
                    foreach ($sub_category->category_with_all_child as $sub_sub_category){
                        $child_categories[]= $sub_sub_category->slug_id;
                        if ($sub_sub_category->category_with_all_child) {
                            foreach ($sub_sub_category->category_with_all_child as $sub_sub_sub_category){
                                $child_categories[]= $sub_sub_sub_category->slug_id;
                                if ($sub_sub_sub_category->category_with_all_child) {
                                    foreach ($sub_sub_sub_category->category_with_all_child as $sub_sub_sub_sub_category){
                                        $child_categories[]= $sub_sub_sub_sub_category->slug_id;
                                        if ($sub_sub_sub_sub_category->category_with_all_child) {
                                            foreach ($sub_sub_sub_sub_category->category_with_all_child as $sub_sub_sub_sub_sub_category){
                                                $child_categories[]= $sub_sub_sub_sub_sub_category->slug_id;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $child_categories;
    }
    /**
     * @param $slug_id
     * @return array
     */

    public function get_category_filter_data($slug_id)
    {

        $child_categories = $this->get_all_child_category($slug_id);

//        return $products = Product::whereHas('category', function ($q) use ($child_products_id) {
//            $q->whereIn('category.slug_id', $child_products_id);
//        })->orderBy('price')->where('price' , '!=' , null)->get()->toArray();


      $products =  Product::with('child_product')->whereHas('category', function ($q) use ($child_categories) {
            $q->whereIn('slug_id', $child_categories);
        })->select('id', 'price', 'variation_product')->orderBy('price')->get();

      $product_has_price = [];
        foreach ($products as $product){
          if ($product['price'] == null) {
              if ($product['variation_product'] == 1 && $product['child_product']) {
                  foreach ($product['child_product'] as $child_product){
                      $product_has_price[] = $child_product['price'];
                  }
              }
          }else{
              $product_has_price[]= $product['price'];
          }
        }


        $lowest_price = min($product_has_price) ;
        $highest_price = max($product_has_price) ;

        $products_id = [];

        foreach ($products as $product){
            $products_id[] = $product['id'];
        }
       // $attributes_values = ProductAttributeValue::select('attribute_value', 'product_attribute_id', 'id')->with('attribute_name')->whereIn('product_id', $products_id)->groupBy('attribute_value')->get();



       // return $attributes_values;



       // $variation_object =  new ProductVariationController();
       // $variation = $variation_object->get_variation_data($this->id);

        return ['lowest_price' => $lowest_price , 'highest_price'=> $highest_price];
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function get_tag_products(Request $request)
    {

        $products = Product::inRandomOrder()->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take(6)->get();
        // return  $products;
        return ProductFrontendResource::collection($products);

//        $tag_id = Tag::where('slug', $request->slug)->first();
//        if ($tag_id) {
//            $products = Product::with('tag')->whereHas('tag', function ($q) use ($tag_id) {
//                $q->where('slug_id', $tag_id->slug_id);
//            })->take($request->take)->get();
//            return response()->json([
//                'data' => $products,
//                'status' => 200
//            ]);
//        } else {
//            return response()->json([
//                'data' => null,
//                'status' => 404
//            ]);
//        }
    }

    public function get_latest_products(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        // return  $products;
        return ProductFrontendResource::collection($products);
    }

    public function get_global_product_for_mobile_index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 3)->take($request->input('take'))->get();
        // return  $products;
        return ProductFrontendResource::collection($products);
    }


    public function get_latest_products_for_home_page()
    {
        $products = Product::orderBy('created_at', 'desc')->with('primary_photo')->where('status', 1)->where('parent', null)->whereIn('product_type_id', [1, 3])->take(6)->get();
        // return  $products;
        return ProductFrontendResource::collection($products);
    }

    public function get_best_selling_product()
    {
        $product = ProductOrderCount::orderBy('sold', 'desc')->with(['product', 'product.primary_photo'])->where('product_type_id', 1)->limit(6)->get();

        //   $products = Product::orderBy('created_at', 'desc')->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        // return  $products;
        return OrderCountProductResource::collection($product);
    }

    public function get_best_selling_products(Request $request)
    {
        $products = ProductOrderCount::orderBy('sold', 'desc')->with(['product', 'product.primary_photo', 'review'])->where('product_type_id', 1)->take($request->input('take'))->get();
        return OrderCountProductResource::collection($products);
    }

    public function get_grocery_products(Request $request)
    {
        $products = Product::where('status', 1)->whereHas('category', function ($q) use ($request) {
            $q->where('slug', 'like', '%' . $request->slug . '%');
        })->take(12)->get();

        return response()->json([
            'data' => $products,
            'status' => 200
        ]);
    }


    public function get_new_arrival_products(Request $request)
    {
        $order_by = 'created_at';
        $direction = 'desc';

        if ($request->input('order_by') == 'created_at') {
            $order_by = 'created_at';
            $direction = 'desc';
        } elseif ($request->input('order_by') == 'high_to_low') {
            $order_by = 'price';
            $direction = 'desc';
        } elseif ($request->input('order_by') == 'low_to_high') {
            $order_by = 'price';
            $direction = 'asc';
        }
        $products = Product::orderBy($order_by, $direction)->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        // return  $products;
        return ProductFrontendResource::collection($products);
    }


    public function get_flash_deal_products(Request $request)
    {
        $order_by = 'created_at';
        $direction = 'desc';

        if ($request->input('order_by') == 'created_at') {
            $order_by = 'created_at';
            $direction = 'desc';
        } elseif ($request->input('order_by') == 'high_to_low') {
            $order_by = 'price';
            $direction = 'desc';
        } elseif ($request->input('order_by') == 'low_to_high') {
            $order_by = 'price';
            $direction = 'asc';
        }
        $products = Product::orderBy($order_by, $direction)->with('primary_photo')->where('status', 1)->where('parent', null)->where('product_type_id', 1)->take($request->input('take'))->get();
        // return  $products;
        return ProductFrontendResource::collection($products);
    }


    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */

    public function search(Request $request)
    {
        //  product_name: "nai"
        //  search_category: 141
        if (isset($request->search_category) && $request->search_category != null) {
             $category = Category::with('product_search')->findOrFail($request->input('search_category'));
             $product = $category->setRelation('product_search', $category->product_search()->where('product_name', 'like', '%'.$request->input('product_name').'%')->paginate(10));
             $product = $product->product_search;

           // $product = Product::where('status', 1)->where('product_name', 'like', '%' . $request->product_name . '%')->take(10)->get();
        } else {
            $product = Product::where('status', 1)->where('product_name', 'like', '%' . $request->product_name . '%')->paginate(10);
        }
        return ProductSearchResource::collection($product);
    }

    public function search_result(Request $request, $product_name, $id = null)
    {

        if ($id != null) {
            $products = Product::where('status', 1)->whereIn('product_type_id', [1, 3])->where('product_name', 'like', '%' . $product_name . '%')->paginate(20);
        } else {
            $products = Product::where('status', 1)->whereIn('product_type_id', [1, 3])->where('product_name', 'like', '%' . $product_name . '%')->paginate(20);
        }
        return ProductFrontendResource::collection($products);
    }


    public function all_recommended_products(Request $request)
    {

        if (!$request->exists('product_id')) {
            $product = Product::with('primary_photo')->inRandomOrder()->limit(12)->get();
            return   ProductFrontendResource::collection($product);
        }

        $original_product = Product::with('category')->where('slug_id', $request->input('product_id'))->first();

        if ($original_product && $original_product->category) {
            $category_id = $original_product->category[0]->id;

            $category = Category::with('category_with_all_parent')->where('id', $category_id)->first();
            $index = $category->category_with_all_parent;
            $parent_id = $category_id;
            while ($index) {
                if ($index->category_with_all_parent) {
                    $parent_id = $index->category_with_all_parent->id;
                }
                $index = $index->category_with_all_parent;
            }

            $category = Category::with('product')->findOrFail($category_id);
            if ($category && count($category->product) > 12) {
                return   ProductFrontendResource::collection($category->product);
            }else{
                $product = Product::with('primary_photo')->inRandomOrder()->limit(12)->get();
                return   ProductFrontendResource::collection($product);
            }
        }

    }
}
