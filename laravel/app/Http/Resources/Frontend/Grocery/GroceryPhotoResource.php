<?php

namespace App\Http\Resources\Frontend\Grocery;

use Illuminate\Http\Resources\Json\JsonResource;

class GroceryPhotoResource extends JsonResource
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
            'photo' => url('images/uploads/products_thumb/'.$this->product_photo) ,
        ];
    }
}
