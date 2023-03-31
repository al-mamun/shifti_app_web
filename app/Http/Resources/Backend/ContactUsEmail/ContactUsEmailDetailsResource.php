<?php

namespace App\Http\Resources\Backend\ContactUsEmail;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $email
 * @property mixed $message
 * @property mixed $subject
 * @property mixed $created_at
 */
class ContactUsEmailDetailsResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'message'=>$this->message,
            'subject'=>$this->subject,
            'created_at'=>$this->created_at->toDayDateTimeString(),
        ];
    }
}
