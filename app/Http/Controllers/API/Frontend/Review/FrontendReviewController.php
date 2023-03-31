<?php

namespace App\Http\Controllers\API\Frontend\Review;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Product\ProductFrontendResource;
use App\Http\Resources\Frontend\Review\ReviewProductListResource;
use App\Http\Resources\Frontend\Review\ReviewResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FrontendReviewController extends Controller
{
    /**
     * @param $slug_id
     * @return AnonymousResourceCollection
     */
    public function index($slug_id): AnonymousResourceCollection
    {
        $product = Product::select('id')->where('slug_id', $slug_id)->first();
        $review = Review::where('review_id', null)->where('product_id', $product->id)->with(['customer', 'replay'])->latest()->get();
        return ReviewResource::collection($review);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = 0;
        $data['customer_id'] = auth()->user()->id;

        if ($request->review_photo) {
            $file = $request->review_photo;
            $dimensions = getimagesize($file);
            $height = $dimensions[1];
            $width = $dimensions[0];
            $path = 'images/uploads/product_review/';
            $name = $name = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $data['review_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['review_photo'] = null;
        }

        Review::create($data);
    }


    public function getCalculatedReview($slug): float|int
    {
        $product = Product::with('review')->where('slug_id', $slug)->first();
        $review_star = 0;
        $review_count = 0;
        $ratings = 0;
        if ($product->review) {
            foreach ($product->review as $review){
                if ($review->review_id == null && $review->star != null) {
                    $review_star+=$review->star;
                    $review_count+=1;
                }
            }
        }
        if ($review_star > 0 && $review_count > 0) {
            $ratings =  $review_star / $review_count;
        }
        return number_format($ratings, 2);
    }


    /**
     * @return AnonymousResourceCollection
     */
    public function get_products_for_review(): AnonymousResourceCollection
    {
        $my_orders = Order::select('id')->where('customer_id', auth()->user()->id)->get();
        $my_order_products = OrderProduct::select('product_id')->whereIn('order_id', $my_orders)->distinct()->get();
        $products_id = [];
        foreach ($my_order_products as $my_order_product) {
            $product = Product::where('id', $my_order_product->product_id)->first();
            if ($product and $product->parent != null) {
                $products_id[] = $product->parent;
            } else {
                $products_id[] = $product->id;
            }
        }
        $products = Product::doesntHave('my_review')->with(['primary_photo', 'bestSellingProduct'])->whereIn('id', $products_id)->get();
        return ProductFrontendResource::collection($products);
    }


    /**
     * @return AnonymousResourceCollection
     */
    public function get_my_reviewed_product(): AnonymousResourceCollection
    {
        $reviews = Review::with(['product', 'product.primary_photo', 'product.bestSellingProduct'])->where('customer_id', auth()->user()->id)->whereNull('review_id')->groupBy('product_id')->latest()->paginate(20);
        return ReviewProductListResource::collection($reviews);
    }
}
