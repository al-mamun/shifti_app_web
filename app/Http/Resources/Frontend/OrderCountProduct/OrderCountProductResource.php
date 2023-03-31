<?php

namespace App\Http\Resources\Frontend\OrderCountProduct;

use App\Http\Resources\Backend\Product\ProductFrontendResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCountProductResource extends JsonResource
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
            'sold' =>$this->sold,
            'product' =>new ProductFrontendResource($this->product),
        ];
    }
}
