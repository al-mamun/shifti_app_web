<?php

namespace App\Http\Resources\Backend\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDeliveryResource extends JsonResource
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
            'order_type' => $this->order_type,
            'ship_from' => $this->ship_from,
            'free_shipping' => $this->free_shipping,
            'delivery_time' => $this->delivery_time,
        ];
    }
}
