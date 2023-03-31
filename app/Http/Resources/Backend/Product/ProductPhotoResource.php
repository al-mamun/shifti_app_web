<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id'                            => $this->id,
            'product_photo'                 => url('/images/uploads/products_thumb/'. $this->product_photo),
            'product_photo_original'        => url('/images/uploads/products/'. $this->product_photo),
        ];
    }
}
