<?php

namespace App\Http\Resources\Backend\ContactUsEmail;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $phone
 * @property mixed $message
 * @property mixed $subject
 * @property mixed $email
 * @property mixed $id
 * @property mixed $created_at
 */
class ContactUsEmailListResource extends JsonResource
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
            'email'=>$this->email,
            'subject'=>$this->subject,
            'message'=>$this->message,
            'phone'=>$this->phone,
            'created_at'=>$this->created_at->toDayDateTimeString(),
        ];
    }
}
