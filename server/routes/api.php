<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('/posts')->group(function () {
  Route::get('', [PostController::class, 'index']);
  // Route::get('/{id}', [PostController::class, 'show']);

  Route::middleware(JwtAuthMiddleware::class)->group(function () {
    Route::post('', [PostController::class, 'store']);
    Route::post('/{post}/like', [PostController::class, 'toggleLike']);
    Route::post('/{post}/comment', [PostController::class, 'addComment']);
    Route::delete('/{post}/comment/{comment}', [PostController::class, 'removeComment']);
  });
});

Route::prefix('/user')->group(function () {
  Route::get('/{id}', [UserController::class, 'show']);

  Route::middleware(JwtAuthMiddleware::class)->group(function () {
    Route::post('/{user}/subscribe', [UserController::class, 'subscribe']);
    Route::post('/{user}/unsubscribe', [UserController::class, 'unsubscribe']);
  });
});


Route::prefix('/auth')->group(function () {
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/refresh', [AuthController::class, 'refresh']);

  Route::middleware(JwtAuthMiddleware::class)->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});
