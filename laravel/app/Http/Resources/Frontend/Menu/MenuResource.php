<?php

namespace App\Http\Resources\Frontend\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $sub_category
 * @property mixed $feature_photo
 * @property mixed $icon
 * @property mixed $category_name
 * @property mixed $slug_id
 * @property mixed $slug
 * @property mixed $id
 */
class MenuResource extends JsonResource
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
            'category_name'=>$this->category_name,
            'slug'=>$this->slug,
            'slug_id'=>$this->slug_id,
            'icon'=>$this->icon != null ? url('images/uploads/category_icon/'.$this->icon): url('images/orpon-bd-loader.png'),
            'feature_photo'=>$this->feature_photo != null ? url('images/uploads/category_icon/'.$this->feature_photo): url('images/orpon-bd-loader.png'),
            'sub_category' => MenuResource::collection($this->sub_category)
        ];
    }
}
