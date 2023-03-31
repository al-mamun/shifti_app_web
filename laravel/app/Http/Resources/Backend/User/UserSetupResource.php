<?php

namespace App\Http\Resources\Backend\User;

use App\Http\Resources\Backend\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSetupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'photo' => $this->photo != null ? url('/images/uploads/users') . '/' . $this->photo : null,
            'phone' => $this->phone,
            'updated_at' => $this->updated_at != null ?$this->updated_at->toDayDateTimeString():null,
            'created_at' => $this->created_at != null?$this->created_at->toDayDateTimeString():null,
            'role' => $this->role != null ? new RoleResource($this->role) : null,

        ];
    }
}
