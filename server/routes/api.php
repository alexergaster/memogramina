<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('/posts')->group(function () {
  Route::get('', [PostController::class, 'index']);
  Route::get('/{id}', [PostController::class, 'show']);
});

Route::prefix('/user')->group(function () {
  Route::get('/{id}', [UserController::class, 'show']);
});
// ->middleware(JwtAuthMiddleware::class)


Route::prefix('/auth')->group(function () {
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/refresh', [AuthController::class, 'refresh']);

  Route::middleware(JwtAuthMiddleware::class)->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});
