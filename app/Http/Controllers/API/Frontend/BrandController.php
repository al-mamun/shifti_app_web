<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductFrontendResource;
use App\Http\Resources\Frontend\Brand\BrandListResource;
use App\Models\Brand;
use App\Models\BrandLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
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

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */

    public function get_brands(Request $request): AnonymousResourceCollection
    {
        $brands = Brand::orderBy('order_by', 'asc')->with('like')->where('status', 1)->take(6)->get();
        return BrandListResource::collection($brands);

    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */

    public function get_brand_list(Request $request): AnonymousResourceCollection
    {
        $brands = Brand::orderBy('order_by', 'asc')->where('status', 1)->get();
        return BrandListResource::collection($brands);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_brand_details(int $id)
    {

        $brand = Brand::with(['product'])->where('slug_id', $id)->first();
        $like = 0;
        if (auth()->check()) {
            $is_liked = BrandLike::where('customer_id', auth('sanctum')->user()->id)->where('brand_id', $brand->id)->first();
            if ($is_liked && $is_liked->is_liked == 1) {
                $like =1;
            }
        }
        $brand_data = [
            'id' => $brand->id,
            'name' => $brand->brand_name,
            'slug_id' => $brand->slug_id,
            'logo' => $brand->logo != null ? url('/images/uploads/brand_logo/' . $brand->logo) : null,
            'feature_photo' => $brand->feature_photo != null ? url('/images/uploads/brand_logo/' . $brand->feature_photo) : null,
            'slug' => $brand->slug,
            'product' => $brand->product?->count(),
            'like' =>  BrandLike::where('brand_id',  $brand->id)->where('is_liked', 1)->count(),
            'is_liked' => $like,
            'review' => $this->calculate_brand_product_review($brand->slug_id),
            'sold' => $this->calculate_brand_product_sold($brand->slug_id),
        ];
        return response()->json($brand_data);
    }

    public function calculate_brand_product_sold($slug_id): int
    {
        $brand = Brand::with('product', 'product.bestSellingProduct')->where('slug_id', $slug_id)->first();
        $sold = 0;
        if ($brand->product) {
            foreach ($brand->product as $product){
                if ($product->bestSellingProduct) {
                     $sold+= $product->bestSellingProduct->sold;
                }
            }

        }
        return $sold;
    }


    public function calculate_brand_product_review($slug_id): int|string
    {
        $brand = Brand::with('product', 'product.review')->where('slug_id', $slug_id)->first();
        $review_star = 0;
        $review_count = 0;
        if ($brand->product) {
            foreach ($brand->product as $product){
                $single_product_star = 0;
                $single_product_count = 0;

                if ($product->review) {
                    foreach($product->review as $review){
                        if ($review->review_id == null && $review->star != null) {
                            $single_product_count+=1;
                            $single_product_star+=$review->star;
                        }
                    }
                    if ($single_product_star > 0 && $single_product_count > 0) {
                        $review_star =$single_product_star/$single_product_count ;
                        $review_count+=1;
                    }
                }
            }
        }

        if ($review_star > 0 && $review_count > 0) {
            $product_review = number_format($review_star/$review_count, 2) ;
        }else{
            $product_review = 0;
        }
        return $product_review;
    }

    /**
     * @param int $slug_id
     * @return AnonymousResourceCollection
     */

    public function get_brand_products(Request $request, int $slug_id): AnonymousResourceCollection
    {
        $direction = $request->input('direction') ?? 'desc';
        $column = $request->input('column') ?? 'created_at';

        $brand = Brand::with(['brand_product', 'brand_product.primary_photo'])->where('slug_id', $slug_id)->first();
        if (strlen($request->input('search')) > 2 ) {
            $products = $brand->setRelation('brand_product', $brand->brand_product()->orderBy($column, $direction )->where('product_name', 'like', '%'.$request->input('search').'%')->paginate(10));
        }else{
            $products = $brand->setRelation('brand_product', $brand->brand_product()->orderBy($column, $direction )->paginate(10));
        }

        return ProductFrontendResource::collection($products->brand_product);
    }

    public function update_brand_like(int $id)
    {
        $brand = Brand::with(['product'])->where('slug_id', $id)->first();
        if ($brand) {
            $like = BrandLike::where('brand_id', $brand->id)->first();
            if ($like) {
                if ($like->is_liked == 0) {
                    $data['is_liked'] = 1;
                }else{
                    $data['is_liked'] = 0;
                }

                $like->update($data);

            }else{
                $data['is_liked'] = 1;
                $data['brand_id'] = $brand->id;
                $data['customer_id'] = auth()->user()->id;
                BrandLike::create($data);
            }
        }

    }
}
