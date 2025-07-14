<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Blog\CommentController;
use App\Http\Controllers\Blog\PostController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});


Route::middleware('auth:sanctum')->group(function () {
    //posts
    Route::apiResource('posts', PostController::class);
    Route::get('/all/posts', [PostController::class, 'getPosts']);
    Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force', [PostController::class, 'forceDelete'])->name('post.force');
    Route::get('/posts/{id}/comments', [PostController::class, 'comments']);
    //comments
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('users', UserController::class);

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
