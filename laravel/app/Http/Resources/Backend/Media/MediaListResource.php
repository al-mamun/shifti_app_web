<?php

namespace App\Http\Resources\Backend\Media;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $product_photo
 */
class MediaListResource extends JsonResource
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
            'id' => $this->id,
            'photo' =>file_exists( public_path('images/uploads/products_thumb/'.$this->product_photo)) ? url('images/uploads/products_thumb/'.$this->product_photo) : url('images/uploads/media/'.$this->product_photo),
            'link' => url('images/uploads/products/'.$this->product_photo),
        ];
    }
}
