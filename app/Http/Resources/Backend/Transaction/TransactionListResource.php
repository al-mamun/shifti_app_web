<?php

namespace App\Http\Resources\Backend\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionListResource extends JsonResource
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
            'amount'=>$this->amount,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'transaction_id'=>$this->transaction_id,
            'payment_method' => $this->payment_method?->name,
        ];
    }
}
