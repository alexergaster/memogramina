<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Services\User\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function show($id): JsonResponse
    {
        $user = User::with(['following', 'followers'])->findOrFail($id);

        $posts = Post::with(['user', 'likedByUsers', 'comments.user'])->where('user_id', $id)->get();

        return response()->json(["success" => true, "data" => ["user" => $user, "posts" => PostResource::collection($posts)]]);
    }

    public function subscribe(User $user): JsonResponse
    {
        $id =  JWTAuth::parseToken()->authenticate();

        try {
            DB::beginTransaction();

            $user->followers()->attach($id);

            DB::commit();

            return response()->json(['success' => true, 'user' => $id], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function unsubscribe(User $user): JsonResponse
    {
        $id =  JWTAuth::parseToken()->authenticate();

        try {
            DB::beginTransaction();

            $user->followers()->detach($id);

            DB::commit();

            return response()->json(['success' => true, 'user' => $id]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(): JsonResponse
    {
        $user =  JWTAuth::parseToken()->authenticate();

        return response()->json(['success' => true, "data" => $user]);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $user =  JWTAuth::parseToken()->authenticate();


        if (isset($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // TODO: resize image

            $path = $image->store('profille', 'public');

            $data['image'] = env('APP_URL') . ':' . env('APP_PORT') . Storage::url($path);
        }

        return $user->update($data);
    }
}
