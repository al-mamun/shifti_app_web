<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed id
 * @property mixed attribute_value
 * @property mixed status
 * @property mixed order_by
 * @property mixed attribute_name
 */
class ProductAttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'attribute_value'   => $this->attribute_value,
            'status'            => $this->status  ==  1,
            'order_by'          => $this->order_by,
            'attribute_name'    => $this->attribute_name->attribute_name,
            'product_attribute_id'    => $this->attribute_name->id,
        ];
    }
}
