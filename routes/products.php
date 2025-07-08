<?php
use App\Http\Controllers\ProductControllers;
use Illuminate\Support\Facades\Route;

Route::resource('products',ProductControllers::class);
