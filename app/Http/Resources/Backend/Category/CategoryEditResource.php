<?php

namespace App\Http\Resources\Backend\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $category_name
 * @property mixed $feature_photo
 * @property mixed $icon
 * @property mixed $order_by
 * @property mixed $parent
 * @property mixed $primary_category
 * @property mixed $product_type_id
 * @property mixed $slug
 * @property mixed $status
 * @property mixed $seo
 */
class CategoryEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category_name' => $this->category_name,
            'feature_photo' => $this->feature_photo != null? url('images/uploads/category_icon').'/'.$this->feature_photo:null,
            'icon' => $this->icon != null? url('images/uploads/category_icon').'/'.$this->icon:null,
            'order_by' => $this->order_by,
            'parent' => $this->parent,
            'primary_category' => $this->primary_category,
            'product_type_id' => $this->product_type_id,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->seo?->description,
            'keywords' => $this->seo?->keywords,
        ];
    }
}
