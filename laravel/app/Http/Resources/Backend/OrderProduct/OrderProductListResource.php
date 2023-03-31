<?php

namespace App\Http\Resources\Backend\OrderProduct;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_amount = 0;
        if($this->discount_price != null){
            $total_amount = $this->discount_price * $this->quantity;
        }else{
            $total_amount = $this->price * $this->quantity;
        }
        return [
            'id' =>$this->id,
            'product_name' =>$this->product_name,
            'product_photo' => url('/images/uploads/products_thumb/'.$this->product_photo),
            'total_amount' =>  $total_amount,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
        ];
    }
}
