<?php

namespace App\Http\Resources\Frontend\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductVariationResrouce extends JsonResource
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
            'id'                =>$this->id,
            'attribute_name'    =>$this->attribute_name,
            'product_id'        =>$this->product_id,
            'attribute_value'   =>CartProductVariationValueResource::collection($this->attribute_value),
        ];
    }
}
