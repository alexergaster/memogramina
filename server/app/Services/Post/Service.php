<?php

namespace App\Services\Post;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;

class Service
{
  public function store(array $data, StoreRequest $request)
  {
    $image = $request->file('image');

    // TODO: resize image

    $path = $image->store('images', 'public');

    $data['image'] = env('APP_URL') . ':' . env('APP_PORT') . Storage::url($path);

    return Post::create($data);
  }

  public function toggleLike($post): array
  {
    $user = JWTAuth::parseToken()->authenticate();

    $userId = $user["id"];

    if ($post->likedByUsers()->where('user_id', $userId)->exists()) {
      $post->likedByUsers()->detach($userId);

      return ['message' => 'Like removed', 'user' => new UserResource($user)];
    } else {
      $post->likedByUsers()->attach($userId);

      return ['message' => 'Liked', 'user' => $user];
    }
  }
}
