<?php

namespace App\Http\Resources\Backend;

use App\Http\Requests\Backend\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed category_name
 * @property mixed order_by
 * @property mixed status
 * @property mixed icon
 * @property mixed slug
 * @property mixed level
 * @property mixed parent
 * @property mixed slug_id
 * @property mixed sub_category
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed seo
 * @property mixed product_type_id
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
       // return parent::toArray($request);
        return  [
            'id'                => $this->id,
            'category_name'     => $this->category_name,
            'parent'            => $this->parent,
            'level'             => $this->level,
            'slug'              => $this->slug,
            'slug_id'           => $this->slug_id,
            'icon'              => $this->icon != null ? $this->icon : 'logo.png',
            'status'            => $this->status == 1 ? true : false,
            'order_by'          => $this->order_by,
            'product_type_id'   => $this->product_type_id,
            'created_at'        => $this->created_at->toDayDateTimeString(),
            'updated_at'        => $this->updated_at->toDayDateTimeString(),
            'description'       => $this->seo ? $this->seo->description : null,
            'keywords'          => $this->seo ? $this->seo->keywords : null,
            'sub_category'      => $this->sub_category,
            'parent_name'       => $this->parentCategory != null ? $this->parentCategory->category_name : '',
        ];
    }
}
