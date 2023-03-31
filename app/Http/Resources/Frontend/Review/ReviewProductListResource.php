<?php

namespace App\Http\Resources\Frontend\Review;

use App\Http\Resources\Backend\Product\ProductFrontendResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

/**
 * @property mixed $id
 * @property mixed $star
 * @property mixed $review
 * @property mixed $product
 */
class ReviewProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
public function toArray($request): array
{
        return [
            'id'=>$this->id,
            'star'=>$this->star,
            'review'=>$this->review,
            'product'=> new ProductFrontendResource($this->product),
        ];
    }
}
