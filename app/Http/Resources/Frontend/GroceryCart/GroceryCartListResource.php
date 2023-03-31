<?php

namespace App\Http\Resources\Frontend\GroceryCart;

use App\Http\Controllers\API\PriceCalculator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $quantity
 * @property mixed $id
 * @property mixed $product
 */
class GroceryCartListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $price_calculator = new PriceCalculator();

      //  $discount_amount = $price_calculator->grocery_discount_price_calculate($this->product?->price, $this->product?->discount_type, $this->product?->discount_amount, $this->product?->discount_time);
        $discount_amount =  $price_calculator->discount_amount( $this->product?->price, $this->product?->discount_type, $this->product?->discount_amount);
        $discount_price =  $price_calculator->discount_price_calculate( $this->product?->price, $this->product?->discount_type,  $this->product?->discount_amount) != null? $price_calculator->discount_price_calculate(  $this->product?->price,  $this->product?->discount_type,  $this->product?->discount_amount):null;
        return [
            'id'=>$this->id,
            'quantity'=>$this->quantity,
            'product_name'=>$this->product?->product_name,
            'stock'=>$this->product?->stock,
            'slug'=>$this->product?->slug,
            'slug_id'=>$this->product?->slug_id,
            'sku'=>$this->product?->sku,
            'price'=>$this->product?->price,
            'discount_amount'=>$discount_amount != null ? $discount_amount .'% OFF':null,
            'discount_price' => '৳'.$discount_price,
            'sub_total' => $discount_price!= null?  $discount_price* $this->quantity :$this->product?->price * $this->quantity ,
            'primary_photo'=>$this->product?asset('images/uploads/products_thumb/'.$this->product->primary_photo->product_photo): asset('images/img_bw.png'),
        ];
    }
}
