<?php

namespace App\Http\Resources\Backend\Product;

use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Controllers\API\Frontend\Review\FrontendReviewController;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSortingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $variation_object =  new ProductVariationController();
        $price = $variation_object->calculate_price_for_frontend_product_list($this->id);
        $review_object = new FrontendReviewController();
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'price' => $this->variation_product == 1? explode( $price['original_price'], '৳ '): $this->price,
            'discount_price' =>  $price['discount_price'],
            'discount_amount' => $price['discount_amount'] ,
            'product_type_id' => $this->product_type_id,
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products_thumb/' . $this->primary_photo->product_photo) : url('images/img_bw.png'),
            'slug_id' => $this->slug_id,
            'slug' => $this->slug,
            'sold' => $this->bestSellingProduct?->sold != null ? $this->bestSellingProduct?->sold : 0 ,
            'review' => $review_object->getCalculatedReview($this->slug_id),
            'variation_product' => $this->variation_product,
        ];
    }
}
