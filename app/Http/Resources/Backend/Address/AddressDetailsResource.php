<?php

namespace App\Http\Resources\Backend\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressDetailsResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'landmarks' => $this->landmarks,
            'post_code' => $this->post_code,
            'city' => $this->city?->city_name,
            'zone' => $this->zone?->zone_name,
            'area' => $this->area?->area_name,
        ];
    }
}
