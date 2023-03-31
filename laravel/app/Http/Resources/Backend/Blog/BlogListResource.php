<?php

namespace App\Http\Resources\Backend\Blog;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $photo
 * @property mixed $created_at
 * @property mixed $user
 * @property mixed $slug_id
 * @property mixed $status
 * @property mixed $slug
 * @property mixed $description
 */
class BlogListResource extends JsonResource
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
            'title' => $this->title,
            'photo' => $this->photo != null ? url('images/uploads/blog/' . $this->photo) : url('images/orpon-bd-loader.png'),
            'created_at' => $this->created_at->toDayDateTimeString(),
            'user_name' => $this->user?->name,
            'slug_id' => $this->slug_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }
}
