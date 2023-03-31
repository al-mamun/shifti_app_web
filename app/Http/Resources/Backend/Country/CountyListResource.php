<?php

namespace App\Http\Resources\Backend\Country;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $flags
 * @property mixed $name
 */
class CountyListResource extends JsonResource
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
            'label' =>'<img src="'.url('/images/uploads/flags/'. $this->flags).'" alt=""/>'.' '. $this->name,
            'value' => $this->id,
        ];
    }
}
