<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Post\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            "name" => $this->name,
            "email" => $this->email,
            'posts' => PostResource::collection($this->whenLoaded("posts")),
            'following' => $this->following,
            'followers' => $this->followers
        ];
    }
}
