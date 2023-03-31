<?php

namespace App\Http\Resources\Backend\Order;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use App\Http\Resources\Backend\Address\AddressDetailsResource;
use App\Http\Resources\Backend\Customer\CustomerResource;
use App\Http\Resources\Backend\OrderProduct\OrderProductListResource;
use App\Http\Resources\Backend\Transaction\TransactionListResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $calculate_total_price = OrderPriceCalculator::calculate_total_price($this->order_product);
        $paid_amount = 0;
        if ($this->transaction) {
            foreach ($this->transaction as $transaction){
                $paid_amount+=$transaction->amount;
            }
        }
        return [
            'id'=>$this->id,
            'order_number'=>$this->order_number,
            'address'=> new AddressDetailsResource($this->address),
            'customer'=> new CustomerResource($this->customer),
            'products' => OrderProductListResource::collection($this->order_product),
            'created_at' => $this->created_at->toDayDateTimeString(),
            'amount_after_discount' => $calculate_total_price['amount_after_discount']+ $this->delivery_charge?->delivery_charge,
            'total_amount' => $calculate_total_price['total_amount'],
            'discount' => $calculate_total_price['discount'],
            'shipping_status' => $this->shipping_status?->name,
            'payment_status' => $this->payment_status?->name,
            'shipping_status_id' => $this->shipping_status_id,
            'transaction'=>TransactionListResource::collection($this->transaction),
            'paid_amount' => $paid_amount,
            'delivery_charge' => $this->delivery_charge?->delivery_charge,
            'due_amount' => ($calculate_total_price['amount_after_discount'] - $paid_amount) + $this->delivery_charge?->delivery_charge,
        ];
    }
}
