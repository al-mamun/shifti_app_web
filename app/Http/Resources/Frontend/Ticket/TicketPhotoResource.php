<?php

namespace App\Http\Resources\Frontend\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketPhotoResource extends JsonResource
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
            'photo'=> url('images/uploads/tickets/'.$this->photo),
        ];
    }
}
