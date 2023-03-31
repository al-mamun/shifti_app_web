<?php

namespace App\Http\Resources\Frontend\Product;

use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Resources\Backend\Product\ProductDeliveryResource;
use App\Http\Resources\Backend\Product\ProductPhotoResource;
use App\Http\Resources\Backend\Product\ProductSpecificationsResource;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $video
 * @property mixed $product_specifications
 * @property mixed $productOrderCount
 */
class ProductDetailsForVariationProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $variation_object =  new ProductVariationController();
       $price_object = new PriceCalculatorController();
       $price = $price_object->calculate_price($this->id);
       $variation = $variation_object->get_variation_data($this->id);
       $color_photos = null;
        foreach ($variation as $data){
            if(in_array('Color', $data)){
               $color_photos =  $variation_object->get_color_variation_photos($this->id);
               break;
            }
        }

        return [
            'id' => $this->id,
            'product_cost' => $this->product_cost,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'price' => $price['original_price'],
            'discount_price' =>   $price['discount_price'],
            'discount_amount' =>$price['discount_amount'],
            'product_type_id' => $this->product_type_id,
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products/' . $this->primary_photo->product_photo) : null,
            'slug_id' => $this->slug_id,
            'slug' => $this->slug,
            'brand'=> count($this->brand) > 0 ? $this->brand[0]->brand_name:null,
            'variation_product' => $this->variation_product,
            'product_photo' => ProductPhotoResource::collection($this->product_photo),
            'delivery_information' => new ProductDeliveryResource($this->delivery_information),
            'product_specifications' => ProductSpecificationsResource::collection($this->product_specifications),
            'variation' => $variation,
            'color_photos' =>$color_photos,
            'video' => $this->video?->video_url,
            'product_origin' => $this->country?->name,
            'order_count' => $this->productOrderCount?->sold,
            'store' => $this->store ? new StoreResource($this->store) : new StoreResource(Store::findOrFail(1)),
        ];
    }
}
