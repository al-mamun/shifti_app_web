<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed status
 * @property mixed attribute_name
 * @property mixed order_by
 * @property mixed id
 */
class ProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) :array
    {
        return [
            'id'                => $this->id,
            'attribute_name'    => $this->attribute_name,
            'status'            => $this->status  ==  1,
            'order_by'          => $this->order_by,
            'attribute_value'   => $this->attribute_value,
        ];
    }
}
