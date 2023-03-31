<?php

namespace App\Http\Resources\Backend\Product;

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
 * @property mixed $product_photo
 * @property mixed $delivery_information
 * @property mixed $product_specifications
 */
class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'description' =>  $this->description,
            'sku' => $this->sku,
            'created_at' => $this->created_at->diffForHumans(),
            'price' => $this->price,
            'stock' => $this->stock,
            'status' => $this->status,
            'product_type_id' => $this->product_type_id,
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products/' . $this->primary_photo->product_photo) : null,
            'slug_id' => $this->slug_id,
            'slug' => $this->slug,
            'product_origin' => $this->product_origin,
            'product_cost' => $this->product_cost,
            'product_photo' => ProductPhotoResource::collection($this->product_photo),
            //  'product_variations'    => ProductAttributeResource::collection($this->productVariations),
             'delivery_information'  => new ProductDeliveryResource($this->delivery_information),
             'product_specifications'  =>ProductSpecificationsResource::collection($this->product_specifications),
        ];
    }
}
