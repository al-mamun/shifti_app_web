<?php

namespace App\Http\Resources\Frontend\Address;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $id
 * @property mixed $address
 * @property mixed $phone
 * @property mixed $default_address
 * @property mixed $landmarks
 * @property mixed $post_code
 * @property mixed $customer
 * @property mixed $division
 * @property mixed $district
 * @property mixed $upazila
 * @property mixed $area
 * @property mixed $zone
 * @property mixed $city
 */
class AddressListResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name == null ?  $this->customer->name :  $this->name,
            'address'=>$this->address,
            'phone'=>$this->phone != null ? $this->phone : $this->customer->phone,
            'default_address'=>$this->default_address,
            'landmarks'=>$this->landmarks,
            'post_code'=>$this->post_code,
            'city_name'=>$this->city?->city_name,
            'zone_name'=>$this->zone?->zone_name,
            'area_name'=>$this->area?->area_name,
        ];
    }
}
