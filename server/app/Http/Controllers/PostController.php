<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::with('user')->get();

        return PostResource::collection($posts)->additional(['status' => 'success']);
    }
}
