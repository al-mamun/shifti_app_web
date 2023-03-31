<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed attribute_name
 * @property mixed attribute_value
 * @property mixed id
 */
class AttributeResoruce extends JsonResource
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
            'attribute_name'    => $this->attribute_name,
            'attribute_value'   =>$this->attribute_value,
        ];
    }
}
