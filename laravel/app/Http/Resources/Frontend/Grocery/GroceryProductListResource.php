<?php

namespace App\Http\Resources\Frontend\Grocery;

use App\Http\Controllers\API\PriceCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $primary_photo
 * @property mixed $id
 * @property mixed $product_name
 * @property mixed $description
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $stock
 * @property mixed $price
 * @property mixed $discount_type
 * @property mixed $discount_amount
 * @property mixed $discount_time
 * @property mixed $sku
 * @property mixed $productOrderCount
 */
class GroceryProductListResource extends JsonResource
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

        return [
            'id'=>$this->id,
            'product_name'=>$this->product_name,
            'description'=>$this->description,
            'slug'=>$this->slug,
            'slug_id'=>$this->slug_id,
            'stock'=>$this->stock,
            'product_sold'=> $this->productOrderCount?->sold,
            'price'=>'৳'.$this->price,
            'discount_amount'=> $price_calculator->discount_amount( $this->price, $this->discount_type, $this->discount_amount) != null ?  $price_calculator->discount_amount( $this->price, $this->discount_type, $this->discount_amount)  .'% OFF' : null,
            'discount_price'=>  $price_calculator->discount_price_calculate( $this->price, $this->discount_type, $this->discount_amount) != null? '৳'.$price_calculator->discount_price_calculate( $this->price, $this->discount_type, $this->discount_amount):null,
            'sku'=>$this->sku,
            'primary_photo'=> $this->primary_photo?asset('images/uploads/products_thumb/'.$this->primary_photo->product_photo): asset('images/img_bw.png'),
        ];
    }
}
