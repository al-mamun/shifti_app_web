<?php

namespace App\Http\Resources\Backend\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatuesListResource extends JsonResource
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
            'id'=>$this->id,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'status'=> $this->shipping_status?->name,
            'user'=> $this->user?->name,
            'comment'=> $this->comment,
        ];
    }
}
