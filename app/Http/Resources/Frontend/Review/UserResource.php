<?php

namespace App\Http\Resources\Frontend\Review;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $photo
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request):array
    {
        return [
            'id' =>$this->id,
            'name' =>$this->name,
            'photo' =>$this->photo != null ? url('images/uploads/customers/'.$this->photo) : url('images/uploads/customers/demo.png'),
        ];
    }
}
