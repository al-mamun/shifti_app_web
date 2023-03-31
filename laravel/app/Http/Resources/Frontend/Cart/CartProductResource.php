<?php

namespace App\Http\Resources\Frontend\Cart;

use App\Helpers\Helper;
use App\Http\Controllers\API\Backend\Price\PriceCalculatorController;
use App\Http\Controllers\API\Frontend\ProductVariationController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed product_name
 * @property mixed discount_percent
 * @property mixed price
 * @property mixed stock
 * @property mixed discount_amount
 * @property mixed slug_id
 * @property mixed feature_photo
 * @property mixed product_type_id
 * @property mixed slug
 * @property mixed $parent_product
 * @property mixed $primary_photo
 * @property mixed $product_own_variations
 * @property mixed $variation_product
 */
class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        $variation_object =  new ProductVariationController();
        $price_object = new PriceCalculatorController();
        $price = $price_object->calculate_price($this->id);
        $variation = $variation_object->get_variation_data($this->id);
        $color_photos = null;
        foreach ($variation as $data){
            if(in_array('Color', $data)){
                $color_photos =  $variation_object->get_color_variation_photos($this->id);
                break;
            }
        }

        return [
            'id' => $this->id,
            'product_name' => $this->parent_product?$this->parent_product->product_name:$this->product_name,
            'discount_percent' => $this->discount_percent,
            'price' => $price['original_price'],
            'discount_price' =>   $price['discount_price'],
            'discount_amount' =>$price['discount_amount'],
            'stock' => $this->stock,
            'slug' => $this->slug,
            'variation_product' => $this->variation_product,
            'product_type_id' => $this->product_type_id,
            'feature_photo' =>$this->primary_photo?->product_photo != null? asset('images/uploads/products_thumb/' . $this->primary_photo?->product_photo): asset('images/img_bw.png'),
            'slug_id' => $this->slug_id,
            'calculated_price' => '$'.Helper::calculate_price($this->price, $this->discount_amount, $this->discount_percent),
            'parent_product' => $this->parent_product ? new CartProductResource($this->parent_product) : null,
            'product_own_variations'=> CartProductVariationValueResource::collection($this->product_own_variations),
        ];
    }
}
