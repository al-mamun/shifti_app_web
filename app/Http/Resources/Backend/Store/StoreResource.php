<?php

namespace App\Http\Resources\Backend\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'slug'=>$this->slug,
            'slug_id'=>$this->slug_id,
            'logo'=>$this->logo != null ? url('images/uploads/store/'.$this->logo) : url('images/orpon-bd-loader.png') ,
            'store_name'=>$this->store_name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'status'=>$this->status,
        ];
    }
}
