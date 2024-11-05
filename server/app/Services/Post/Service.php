<?php

namespace App\Services\Post;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\User\UserResource;
use App\Models\Comment;
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

  public function toggleLike(Post $post): array
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
  public function addComment(array $data, Post $post): CommentResource
  {
    $user = JWTAuth::parseToken()->authenticate();

    $data['user_id'] = $user["id"];
    $data['post_id'] = $post->id;

    $comment = Comment::create($data);
    $comment->load('user');

    return new CommentResource($comment);
  }
}
