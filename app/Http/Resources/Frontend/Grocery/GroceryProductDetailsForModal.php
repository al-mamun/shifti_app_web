<?php

namespace App\Http\Resources\Frontend\Grocery;

use App\Http\Controllers\API\PriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $product_name
 * @property mixed $description
 * @property mixed $slug
 * @property mixed $slug_id
 * @property mixed $stock
 * @property mixed $price
 * @property mixed $discount_type
 * @property mixed $discount_amount
 * @property mixed $primary_photo
 * @property mixed $sku
 */
class GroceryProductDetailsForModal extends JsonResource
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
            'price'=>'৳'.$this->price,
            'discount_amount'=> $price_calculator->discount_amount( $this->price, $this->discount_type, $this->discount_amount),
            'discount_price'=>  $price_calculator->discount_price_calculate( $this->price, $this->discount_type, $this->discount_amount),
            'sku'=>$this->sku,
            'product_photo' => GroceryPhotoResource::collection($this->product_photo),
            'review' =>  count($this->review) ,
            'primary_photo'=> $this->primary_photo?asset('images/uploads/products_thumb/'.$this->primary_photo->product_photo): asset('images/img_bw.png'),
        ];
    }
}
