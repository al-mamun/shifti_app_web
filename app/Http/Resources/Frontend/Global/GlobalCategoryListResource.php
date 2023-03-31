<?php

namespace App\Http\Resources\Frontend\Global;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $globalProduct
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $category_name
 */
class GlobalCategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'category_name'=> $this->category_name,
            'slug_id'=> $this->slug_id,
            'slug'=> $this->slug,
            'product' =>GlobalProductListResource::collection($this->globalProduct),
        ];
    }
}
