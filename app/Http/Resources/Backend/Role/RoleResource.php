<?php

namespace App\Http\Resources\Backend\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id'            =>$this->id,
            'name'          =>$this->name,
            'order_by'      =>$this->order_by,
            'status'        =>$this->status == 1 ? true : false,
            'updated_by'    =>$this->updated_by,
            'updated_at'    =>$this->updated_at != null ?$this->updated_at->toDayDateTimeString():null,
            'created_at'    =>$this->created_at != null ?$this->created_at->toDayDateTimeString():null,

        ];
    }
}
