<?php

namespace App\Http\Resources\Frontend\Global;

use App\Http\Controllers\API\Frontend\ProductVariationController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $primary_photo
 * @property mixed $variation_product
 * @property mixed $price
 * @property mixed $slug
 * @property mixed $slug_id
 */
class GlobalProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

    public function toArray($request): array
    {
        $variation_object =  new ProductVariationController();
        $price = $variation_object->calculate_price_for_frontend_product_list($this->id);
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'slug_id' => $this->slug_id,
            'price' => $this->variation_product == 1? $price['original_price'] : '৳ ' . number_format($this->price),
            'feature_photo' => $this->primary_photo != null ? url('/images/uploads/products_thumb/' . $this->primary_photo->product_photo) : url('images/img_bw.png'),
        ];
    }
}
