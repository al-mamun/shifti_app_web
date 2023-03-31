<?php

namespace App\Http\Resources\Frontend\Brand;

use App\Models\BrandLike;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $feature_photo
 * @property mixed $logo
 * @property mixed $id
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $product_photo
 * @property mixed $brand_name
 */
class BrandListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->brand_name,
            'slug_id' => $this->slug_id,
            'logo' => $this->logo != null ? url('images/uploads/brand_logo/' . $this->logo) : url('images/orpon-bd-loader.png'),
            'feature_photo' => $this->feature_photo != null ? url('images/uploads/brand_logo/' . $this->feature_photo) : url('images/orpon-bd-loader.png'),
            'product_photo' => $this->product_photo != null ? url('images/uploads/brand_logo/' . $this->product_photo) : url('images/orpon-bd-loader.png'),
            'like' => BrandLike::where('brand_id', $this->id)->where('is_liked', 1)->count(),
        ];
    }
}
