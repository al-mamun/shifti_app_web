<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAddPageGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'primary'=> $this->primary,
            'photo'=> $this->product_photo != null? url('/images/uploads/products_thumb').'/'.$this->product_photo : null,
        ];
    }
}
