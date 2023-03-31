<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed brand_name
 * @property mixed logo
 * @property mixed order_by
 * @property mixed slug
 * @property mixed slug_id
 * @property mixed status
 * @property mixed updated_at
 * @property mixed created_at
 * @property mixed $feature_photo
 */
class BrandResource extends JsonResource
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
            'id'            =>$this->id,
            'brand_name'    =>$this->brand_name,
            'logo'          =>$this->logo != null ? url('images/uploads/brand_logo/'.$this->logo)  : url('images/orpon-bd-loader.png'),
            'feature_photo'  =>$this->feature_photo != null ? url('images/uploads/brand_logo/'.$this->feature_photo)  : url('images/orpon-bd-loader.png'),
            'product_photo'  =>$this->product_photo != null ? url('images/uploads/brand_logo/'.$this->product_photo)  : url('images/orpon-bd-loader.png'),
            'order_by'      =>$this->order_by,
            'slug'          =>$this->slug,
            'slug_id'       =>$this->slug_id,
            'status'        =>$this->status == 1 ? true : false,
            'updated_at'    =>$this->updated_at->toDayDateTimeString(),
            'created_at'    =>$this->created_at->toDayDateTimeString(),

        ];
    }
}


