<?php

namespace App\Http\Resources\Frontend\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDetailsResource extends JsonResource
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
            'id' =>$this->id,
            'balance' =>$this->balance,
            'created_at' =>$this->created_at->toDayDateTimeString(),
            'email' =>$this->email,
            'name' =>$this->name,
            'phone' =>$this->phone,
            'photo' =>$this->photo != null ? url('images/uploads/customers/'.$this->photo): url('images/uploads/customers/demo.png'),
        ];
    }
}
