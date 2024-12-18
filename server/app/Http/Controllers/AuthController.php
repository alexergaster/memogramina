<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequset;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


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
            'success' => true
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['success' => true, 'token' => $token]);
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['success' => true, 'message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json(['token' =>  $token]);
    }
}
