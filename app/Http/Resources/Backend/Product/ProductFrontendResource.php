<?php

namespace App\Http\Resources\Backend\Product;

use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Controllers\API\Frontend\Review\FrontendReviewController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $product_name
 * @property mixed $description
 * @property mixed $sku
 * @property mixed $created_at
 * @property mixed $price
 * @property mixed $stock
 * @property mixed $status
 * @property mixed $product_type_id
 * @property mixed $feature_photo
 * @property mixed $slug_id
 * @property mixed $slug
 * @property mixed $product_cost
 * @property mixed $primary_photo
 * @property mixed $bestSellingProduct
 * @property mixed $variation_product
 */
class ProductFrontendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $variation_object =  new ProductVariationController();
        $price = $variation_object->calculate_price_for_frontend_product_list($this->id);
        $review_object = new FrontendReviewController();
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'price' => $this->variation_product == 1? $price['original_price'] : '$ ' . $this->price,
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

