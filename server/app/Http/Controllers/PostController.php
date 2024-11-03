<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
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
        $posts = Post::with(['user', 'likedByUsers', 'comments.user'])->get();

        return PostResource::collection($posts)->additional(['status' => 'success']);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $post = $this->service->store($data, $request);

        return response()->json(['success' => true, 'post' => $post]);
    }

    public function toggleLike(Post $post): JsonResponse
    {
        $data = $this->service->toggleLike($post);

        return response()->json(['success' => true, 'data' => $data]);
    }


    public function addComment(CommentRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();

        $response = $this->service->addComment($data, $post);

        return response()->json(['success' => true, 'data' => $response]);
    }

    public function removeComment(Post $post, Comment $comment): JsonResponse
    {
        if ($post->comments()->where('id', $comment->id)->exists()) {
            $comment->delete();
            return response()->json(['success' => true, "comment" => $comment]);
        }

        return response()->json(['success' => false]);
    }

    // public function show($id)
    // {
    //     $post = Post::with('likedByUsers')->get();
    //     // $user = User::with('likedPosts')->get();
    //     return $post;
    // }
}
