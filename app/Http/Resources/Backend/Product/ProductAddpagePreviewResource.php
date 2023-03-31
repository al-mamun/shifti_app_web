<?php

namespace App\Http\Resources\Backend\Product;

use http\Url;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAddpagePreviewResource extends JsonResource
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
            'id' => $this->id,
            'feature_photo' => $this->feature_photo != null? url('/images/uploads/products_thumb').'/'.$this->feature_photo : null,
            'photo_gallery' => ProductAddPageGalleryResource::collection($this->product_photo),
        ];
    }
}
