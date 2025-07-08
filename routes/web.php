<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Author;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\Configuration\GroupCollection;
require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
/*****************************************************************************************************************/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*****************************************************************************************************************/
/*****************************************************************************************************************/

Route::resource('books', BookController::class);
Route::get('users/profile/{id}', [UserController::class, 'profile'])->name('users.profile');
Route::get('users/groups/{id}', [UserController::class, 'groups'])->name('users.groups');

/*****************************************************************************************************************/

Route::get('authors', function () {
    $authors = Author::all();
    return view('authors.index', compact('authors'));
});

Route::get('authors/book/{id}', function ($id) {
    $author = Author::findOrFail($id);
    return view('authors.show', compact('author'));
})->name('authors.show');

Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('groups/user/{id}', [GroupController::class, 'users'])->name('groups.user');

Route::view('groups/alert', 'groups.alert');
/*****************************************************************************************************************/

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::patch('posts/{post}/publish', [PostController::class, 'publish'])->middleware('can:publish,post')->name('posts.publish');
    Route::resource('comments', CommentController::class);
});
/*****************************************************************************************************************/
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});


/*****************************************************************************************************************/

