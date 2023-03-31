<?php

namespace App\Http\Resources\Banner;

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
        return [
            'id' => $this->id,
            'location' => $this->location,
            'banner_photo' => $this->banner_photo  != null ? url('/images/uploads/banners') . '/' . $this->banner_photo : null,
            'status' => $this->status,
            'title' => $this->title,
            'link' => $this->link,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->created_at == $this->updated_at ? 'Not Updated Yet' : $this->updated_at->toDayDateTimeString(),
            'updated_by' => $this->admin,
        ];
    }
}
