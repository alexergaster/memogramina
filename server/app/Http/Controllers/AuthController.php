<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequset;
use App\Http\Resources\User\UserResource;
use App\Services\User\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequset $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->service->register($data);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(compact('token'));
    }
    // TODO: create methods: me(), logout() and refresh()
    // public function me(): JsonResponse
    // {
    //     return response()->json(auth()->user());
    // }

    // // Логаут користувача
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    // // Оновлення токена
    // public function refresh()
    // {
    //     return response()->json(['token' => auth()->refresh()]);
    // }
}
