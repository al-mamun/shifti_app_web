<?php

namespace App\Http\Resources\Frontend\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $city_name
 */
class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'city_name'=>$this->city_name,
        ];
    }
}
