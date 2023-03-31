<?php

namespace App\Http\Resources\Backend\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo  != null ? url('/images/uploads/customers') . '/' . $this->photo : url('/images/uploads/customers/demo.png'),
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->created_at == $this->updated_at ? 'Not Updated Yet' : $this->updated_at->toDayDateTimeString(),
            'updated_by' => $this->admin,
            'balance' => $this->balance,
        ];
    }
}
