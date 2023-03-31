<?php

namespace App\Http\Resources\Frontend\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailsResource extends JsonResource
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
            'description'=>$this->description,
            'subject'=>$this->subject,
            'status'=>$this->status?->status_name,
            'ticket_status_id'=>$this->ticket_status_id,
            'customer_name'=>$this->customer?->name,
            'customer_photo'=>$this->customer?->photo ? url('images/uploads/customers/'.$this->customer?->photo):url('images/uploads/customers/demo.png'),
            'user_name'=>$this->user?->name,
            'user_photo'=>$this->user?->photo ?  url('images/uploads/users/'.$this->user?->photo):url('images/uploads/users/demo.png') ,
            'class' => $this->user ? 'admin-replay': 'customer-replay',
            'photos' => $this->photos ? TicketPhotoResource::collection($this->photos) : null,
            'replay' => $this->replay ? TicketDetailsResource::collection($this->replay) : null,
        ];
    }
}
