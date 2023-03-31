<?php

namespace App\Http\Resources\Frontend\Product;

use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\PriceCalculator;
use App\Http\Resources\Backend\Product\ProductDeliveryResource;
use App\Http\Resources\Backend\Product\ProductPhotoResource;
use App\Http\Resources\Backend\Product\ProductSpecificationsResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $sku
 */
class ChildProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $price_calculator = new PriceCalculatorController();
        $price = $price_calculator->calculate_price($this->id);
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'price' => $price['original_price'],
            'discount_price' =>  $price['discount_price'],
            'discount_amount'=> $price['discount_amount'],
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products/' . $this->primary_photo->product_photo) : null,
            'product_photo' => ProductPhotoResource::collection($this->product_photos_without_primary),
        ];
    }
}
