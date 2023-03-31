<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray([
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'token'         => $this->token,
            'created_at'    =>$this->created_at !=null? $this->created_at->toDayDateTimeString():null,
            'updated_at'    => $this->updated_at != null ? $this->updated_at->toDayDateTimeString(): null,
        ]);
    }
}
