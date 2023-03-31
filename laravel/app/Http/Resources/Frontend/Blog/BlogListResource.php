<?php

namespace App\Http\Resources\Frontend\Blog;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
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
            'description' => substr(strip_tags( $this->description),0, 200) ,
        ];
    }
}
