<?php

namespace App\Http\Resources\Frontend\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $attribute_name
 * @property mixed $id
 */
class CartVariationNameResource extends JsonResource
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
            'id'=>$this->id,
            'attribute_name'=>$this->attribute_name,
        ];
    }
}
