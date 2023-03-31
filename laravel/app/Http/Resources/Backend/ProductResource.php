<?php

namespace App\Http\Resources\Backend;

use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\Backend\Product\ProductStockController;
use App\Http\Controllers\API\Frontend\ProductVariationController;
use App\Http\Resources\Backend\Product\ProductAttributeResource;
use App\Http\Resources\Backend\Product\ProductDeliveryResource;
use App\Http\Resources\Backend\Product\ProductPhotoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed status
 * @property mixed id
 * @property mixed product_name
 * @property mixed sku
 * @property mixed price
 * @property mixed created_at
 * @property mixed stock
 * @property mixed feature_photo
 * @property mixed slug_id
 * @property mixed product_cost
 * @property mixed product_type_id
 * @property mixed product_photo
 * @property mixed productVariations
 * @property mixed delivery_information
 * @property mixed $description
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $price_calculation=  new PriceCalculatorController();
        $price = $price_calculation->calculate_price($this->id);
        $product_stock_object = new ProductStockController();
        $stock = $product_stock_object->calculate_product_stock($this->id);
        $product_cost = $price_calculation->product_cost_calculator($this->id);

        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'sku' => $this->sku,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'price' => $price['original_price'],
            'discount_price' => $price['discount_price'],
            'stock' => $stock,
            'status' => $this->status,
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products/' . $this->primary_photo->product_photo) : null,
            'slug_id' => $this->slug_id,
            'slug' => $this->slug,
            'video' => $this->video != null ?$this->video->video_url :null ,
            'product_cost' => $product_cost,
        ];
    }

    public function with($request): array
    {
        return [
            'status' => 200
        ];
    }
}
