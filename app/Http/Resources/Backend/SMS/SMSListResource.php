<?php

namespace App\Http\Resources\Backend\SMS;

use Illuminate\Http\Resources\Json\JsonResource;

class SMSListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'message_text'=>$this->message_text,
            'number'=>$this->number,
            'status_text'=>$this->status_text,
        ];
    }
}
