<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed updated_at
 * @property mixed created_at
 * @property mixed order_by
 * @property mixed status
 * @property mixed ans
 * @property mixed qus
 * @property mixed id
 */
class ProductFAQResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param   $request
     * @return array
     */
     public function toArray($request): array
    {
       // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'qus'               => $this->qus,
            'ans'               => $this->ans,
            'status'            => $this->status==1 ? 'active' : 'Inactive',
            'order_by'          => $this->order_by,
            'created_at'        => $this->created_at->toDayDateTimeString(),
            'updated_at'        => $this->updated_at->toDayDateTimeString(),
        ];
    }
}
