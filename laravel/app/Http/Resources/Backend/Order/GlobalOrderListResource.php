<?php

namespace App\Http\Resources\Backend\Order;

use App\Http\Resources\Backend\Address\AddressDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GlobalOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'quantity' => $this->global_order_product?->quantity,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'shipping_status' => $this->shipping_status?->name,
            'payment_status' => $this->payment_status?->name,
            'product_name' => $this->global_order_product?->product_name,
            'product_photo' => url('images/uploads/products_thumb/'.$this->global_order_product?->product_photo ),
        ];
    }
}
