<?php

namespace App\Http\Resources\Backend\Store;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $store_name
 * @property mixed $id
 */
class StoreListForProductCreateResource extends JsonResource
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
            'label' => $this->store_name,
            'value' => $this->id,
        ];
    }
}
