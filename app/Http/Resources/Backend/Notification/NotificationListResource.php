<?php

namespace App\Http\Resources\Backend\Notification;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationListResource extends JsonResource
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
            'id'=>$this->id,
            'status'=>$this->status,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'updated_at'=>$this->updated_at->toDayDateTimeString(),
            'order_number'=>$this->order?->order_number,
            'photo'=>  url('/images/uploads/products_thumb/'. $this->order?->order_product[0]?->product_photo),
            'title'=>$this->order?->order_product[0]?->product_name,
        ];
    }
}
