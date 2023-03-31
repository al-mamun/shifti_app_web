<?php

namespace App\Http\Resources\Frontend\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class FrontendCategoryListResource extends JsonResource
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
            'id' =>$this->id,
            'icon' =>$this->icon != null ? url('images/uploads/category_icon/'.$this->icon): url('images/orpon-bd-loader.png'),
            'category_name' =>$this->category_name,
            'slug' =>$this->slug,
            'slug_id' =>$this->slug_id,
        ];
    }
}
