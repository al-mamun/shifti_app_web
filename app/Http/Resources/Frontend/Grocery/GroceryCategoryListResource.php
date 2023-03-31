<?php

namespace App\Http\Resources\Frontend\Grocery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $category_name
 * @property mixed $feature_photo
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $icon
 */
class GroceryCategoryListResource extends JsonResource
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
            'category_name'=>$this->category_name,
            'feature_photo'=>$this->feature_photo != null? asset('images/uploads/category_icon/' . $this->feature_photo):asset('images/img_bw.png'),
            'icon'=>$this->icon != null? asset('images/uploads/category_icon/' . $this->icon):asset('images/img_bw.png'),
            'slug'=>$this->slug,
            'slug_id'=>$this->slug_id,
        ];
    }
}

