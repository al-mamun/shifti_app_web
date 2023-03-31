<?php

namespace App\Http\Resources\Frontend\Banner;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'banner_photo'  =>isset($this->banner_photo) ? url('/images/uploads/banners').'/'.$this->banner_photo : null,
        ];
    }
}
