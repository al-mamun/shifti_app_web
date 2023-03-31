<?php

namespace App\Http\Resources\Frontend\Banner;

use Illuminate\Http\Resources\Json\JsonResource;

class FrontendBannerResource extends JsonResource
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
            'photo'  => url('/images/uploads/sliders').'/'.$this->slider_photo,
            'link'  => $this->link,
        ];
    }
}
