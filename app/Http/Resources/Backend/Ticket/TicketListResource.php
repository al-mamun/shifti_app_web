<?php

namespace App\Http\Resources\Backend\Ticket;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $subject
 * @property mixed $status
 * @property mixed $customer
 */
class TicketListResource extends JsonResource
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
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'subject'=>$this->subject,
            'status'=>$this->status?->status_name,
            'customer_name'=>$this->customer?->name,
            'customer_photo'=>$this->customer?->photo ? url('images/uploads/customers/'.$this->customer?->photo):url('images/uploads/customers/demo.png'),
        ];
    }
}
