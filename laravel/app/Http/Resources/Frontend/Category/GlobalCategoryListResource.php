<?php

namespace App\Http\Resources\Frontend\Category;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $category_name
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $icon
 */
class GlobalCategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id'=>$this->id,
            'category_name'=>$this->category_name,
            'icon'=>$this->icon != null ? url('images/uploads/category_icon/'.$this->icon): url('images/img_bw.png'),
            'slug'=>$this->slug,
            'slug_id'=>$this->slug_id,
        ];
    }
}
