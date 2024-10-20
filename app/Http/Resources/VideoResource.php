<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "description"=> $this->description,
            "video"=> $this->getFirstMediaUrl('videos'),
            'comments' => CommentResource::collection($this->comments),
            'tags' => $this->tags,

          
        ];
    }
}
