<?php

namespace App\Http\Resources\Backend\Order;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use App\Http\Resources\Backend\Address\AddressDetailsResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $shipping_status
 * @property mixed $created_at
 * @property mixed $address
 * @property mixed $customer
 * @property mixed $order_number
 * @property mixed $payment_status
 * @property mixed $id
 * @property mixed $order_product
 */
class GroceryOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {

        $amount = OrderPriceCalculator::calculate_total_price($this->order_product);

        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'customer_name' => $this->customer?->name,
            'address' => new AddressDetailsResource($this->address),
            'created_at' => $this->created_at->format('j M Y'),
            'total_amount' => $amount['amount_after_discount'] + 60,
            'shipping_status' => $this->shipping_status?->name,
            'payment_status' => $this->payment_status?->name,
            'product_count' => $this->order_product  ? count($this->order_product):0,
        ];
    }
}
