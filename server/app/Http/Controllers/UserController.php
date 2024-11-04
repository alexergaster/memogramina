<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use App\Models\User;
use App\Services\User\Service;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        $user = User::with(['following', 'followers'])->findOrFail($id);

        $posts = Post::with(['user', 'likedByUsers', 'comments.user'])->where('user_id', $id)->get();

        return response()->json(["success" => true, "data" => ["user" => $user, "posts" => PostResource::collection($posts)]]);
    }
}
