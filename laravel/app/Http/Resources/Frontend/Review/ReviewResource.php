<?php

namespace App\Http\Resources\Frontend\Review;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $star
 * @property mixed $review_photo
 * @property mixed $review_id
 * @property mixed $product_id
 * @property mixed $customer
 * @property mixed $review
 * @property mixed $id
 * @property mixed $replay
 */
class ReviewResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'review'=>$this->review,
            'customer'=>new UserResource($this->customer),
            'product_id'=>$this->product_id,
            'review_id'=>$this->review_id,
            'review_photo'=>$this->review_photo,
            'star'=>$this->star,
            'created_at'=>$this->created_at->toDayDateTimeString(),
            'replay'=>ReviewResource::collection($this->replay),
        ];
    }
}
