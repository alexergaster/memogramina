<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\Post\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index(): AnonymousResourceCollection
    {
        $posts = Post::with(['user', 'comments.user'])->get();

        return PostResource::collection($posts)->additional(['status' => 'success']);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $post = $this->service->store($data, $request);

        return response()->json(['success' => true, 'post' => $post]);
    }
    // public function show($id)
    // {
    //     $post = Post::findOrFail($id);

    //     dd($post->comments);
    // }
}
