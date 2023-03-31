<?php

namespace App\Http\Resources\Slider;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'slider_photo' => $this->slider_photo != null ? url('/images/uploads/sliders') . '/' . $this->slider_photo : null,
            'status' => $this->status,
            'type' => $this->type,
            'order_by' => $this->order_by,
            'location' => $this->location,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->created_at == $this->updated_at ? 'Not Updated Yet' : $this->updated_at->toDayDateTimeString(),
            'updated_by' => $this->admin,
        ];
    }
}
