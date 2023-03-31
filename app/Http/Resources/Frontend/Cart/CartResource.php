<?php

namespace App\Http\Resources\Frontend\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed product_id
 * @property mixed quantity
 * @property mixed product
 * @property mixed cartVariation
 * @property mixed selected
 * @property mixed $parent_product
 */
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'selected' => $this->selected,
            'product_type_id' => $this->product->product_type_id,
            'product' => new CartProductResource($this->product),
        ];
    }
}
