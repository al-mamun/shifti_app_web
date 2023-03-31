<?php

namespace App\Http\Resources\Frontend\Profile;


use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'email'         =>$this->email,
            'balance'         =>$this->balance,
            'photo'         => $this->photo != null ? url('/images/uploads/customers') . '/' . $this->photo : url('images/uploads/users/demo.png'),
            'updated_at'    =>$this->updated_at->toDayDateTimeString(),
            'created_at'    =>$this->created_at->toDayDateTimeString(),


        ];
    }
}
