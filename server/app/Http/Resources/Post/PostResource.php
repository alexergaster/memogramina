<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'caption' => $this->caption,
            "created_at" => $this->created_at,
            'likes' => UserResource::collection($this->whenLoaded('likedByUsers')),
            'user' => new UserResource($this->whenLoaded("user")),
            'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'status' => [
                'key' => 'value',
            ],
        ];
    }
}
