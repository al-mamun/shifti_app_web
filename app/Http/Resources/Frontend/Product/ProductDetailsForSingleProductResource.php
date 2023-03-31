<?php

namespace App\Http\Resources\Frontend\Product;

use App\Http\Controllers\API\PriceCalculator;
use App\Http\Resources\Backend\Product\ProductDeliveryResource;
use App\Http\Resources\Backend\Product\ProductPhotoResource;
use App\Http\Resources\Backend\Product\ProductSpecificationsResource;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $product_name
 * @property mixed $description
 * @property mixed $sku
 * @property mixed $brand
 * @property mixed $price
 * @property mixed $discount_time
 * @property mixed $stock
 * @property mixed $product_type_id
 * @property mixed $primary_photo
 * @property mixed $slug_id
 * @property mixed $slug
 * @property mixed $product_origin
 * @property mixed $variation_product
 * @property mixed $video
 * @property mixed $product_photo
 * @property mixed $delivery_information
 * @property mixed $product_specifications
 * @property mixed $review
 * @property mixed $country
 */
class ProductDetailsForSingleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $price_calculator = new PriceCalculator();

        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'sku' => $this->sku,
            'brand'=> count($this->brand) > 0 ? $this->brand[0]->brand_name:null,
            'price' => '$ '.  $this->price,
            'discount_price' =>   $this->discount_time != null && Carbon::now()->lessThanOrEqualTo($this->discount_time) ?$price_calculator->discount_price_calculate( $this->price, $this->discount_type, $this->discount_amount):null ,
            'stock' => $this->stock,
            'product_type_id' => $this->product_type_id,
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products/' . $this->primary_photo->product_photo) : null,
            'slug_id' => $this->slug_id,
            'slug' => $this->slug,
            'product_origin' => $this->country?->name,
            'order_count' => $this->productOrderCount?->sold,
            'variation_product' => (int) $this->variation_product,
            'video' => $this->video?->video_url,
            'product_photo' => ProductPhotoResource::collection($this->product_photo),
            'delivery_information' => new ProductDeliveryResource($this->delivery_information),
            'product_specifications' => ProductSpecificationsResource::collection($this->product_specifications),
            'store' => $this->store ? new StoreResource($this->store) : new StoreResource(Store::findOrFail(1)),
        ];
    }
}
