<?php

namespace App\Http\Resources\Backend\Notification;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use App\Http\Resources\Backend\Customer\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationAllListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $calculate_total_price = OrderPriceCalculator::calculate_total_price($this->order->order_product);

        return [
            'id'=>$this->id,
            'status'=>$this->status,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'updated_at'=>$this->updated_at->toDayDateTimeString(),
            'order_number'=>$this->order?->order_number,
            'photo'=>  url('/images/uploads/products_thumb/'. $this->order?->order_product[0]?->product_photo),
            'title'=>$this->order?->order_product[0]?->product_name,
            'customer'=> $this->order->customer?->name,
            'price'=>$calculate_total_price['amount_after_discount'],
            'user_name' => $this->user?->name,
        ];
    }
}
