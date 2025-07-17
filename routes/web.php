<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');
Route::get('/login', function () {
    return Inertia::render('auth/login');
})->name('login');
Route::get('/register', function () {
    return Inertia::render('auth/register');
})->name('register');

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
});

Route::get('/posts/', function () {
    return Inertia::render('posts/index');
});
Route::get('/posts/trash', function () {
    return Inertia::render('posts/trash');
});
Route::get('/posts/{id}', function ($id) {
    return Inertia::render('posts/show', ['id' => $id]);
})->name('posts.show');
Route::get('/posts/{id}/edit', function ($id) {
    return Inertia::render('posts/edit', ['id' => $id]);
})->name('posts.edit');

Route::get('/users', function () {
    return Inertia::render('users/index');
});







// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
// });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
