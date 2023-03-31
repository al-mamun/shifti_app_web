<?php

namespace App\Http\Resources\Frontend\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $store_name
 * @property mixed $id
 * @property mixed $upazila
 */
class StoreResource extends JsonResource
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
            'store_name'=>$this->store_name,
            'upazila'=>$this->upazila?->name,
        ];
    }
}
