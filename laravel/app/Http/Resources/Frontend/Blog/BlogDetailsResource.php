<?php

namespace App\Http\Resources\Frontend\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'photo'=>$this->photo != null? url('images/uploads/blog/'.$this->photo) : url('images/orpon-bd-loader.png'),
            'created_at' =>$this->created_at->toDayDateTimeString(),
            'user_name' => $this->user?->name,
            'slug_id' => $this->slug_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'description' =>  $this->description ,
        ];
    }
}
