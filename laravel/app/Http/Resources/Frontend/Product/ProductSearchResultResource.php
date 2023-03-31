<?php

namespace App\Http\Resources\Frontend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed feature_photo
 * @property mixed slug_id
 * @property mixed slug
 * @property mixed product_name
 * @property mixed id
 * @property mixed price
 */
class ProductSearchResultResource extends JsonResource
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
            'id'                => $this->id,
            'product_name'      => $this->product_name,
            'slug'              => $this->slug,
            'slug_id'           => $this->slug_id,
            'feature_photo'     => $this->feature_photo,
            'price'             => $this->price,
        ];
    }
}
