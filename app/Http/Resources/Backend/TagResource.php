<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed order_by
 * @property mixed slug
 * @property mixed slug_id
 * @property mixed status
 * @property mixed tag_name
 * @property mixed updated_at
 * @property mixed created_at
 */
class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request) :array
    {
        return [
            'id'            =>$this->id,
            'order_by'      =>$this->order_by,
            'slug'          =>$this->slug,
            'slug_id'       =>$this->slug_id,
            'status'        =>$this->status == 1? true:false,
            'tag_name'      =>$this->tag_name,
            'created_at'    =>$this->created_at->toDayDateTimeString(),
            'updated_at'    =>$this->created_at == $this->updated_at ?'Not Updated Yet': $this->updated_at->toDayDateTimeString(),
        ];
    }
}
