<?php

namespace App\Http\Resources\Frontend\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $attribute_value
 * @property mixed $id
 * @property mixed $attribute_name
 */
class CartProductVariationValueResource extends JsonResource
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
            'attribute_value' => $this->attribute_value,
            'attribute_name' => new CartVariationNameResource($this->attribute_name),
        ];
    }
}
