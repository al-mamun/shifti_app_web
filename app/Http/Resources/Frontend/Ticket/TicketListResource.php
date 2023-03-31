<?php

namespace App\Http\Resources\Frontend\Ticket;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $subject
 * @property mixed $status
 */
class TicketListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'=>$this->id,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'subject'=>$this->subject,
            'status'=>$this->status?->status_name,
        ];
    }
}
