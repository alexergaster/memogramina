<?php

namespace App\Http\Controllers;

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

    public function show($id): JsonResponse
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'following', 'followers'])->findOrFail($id);

        return response()->json(["success" => true, "data" => $user]);
    }
}
