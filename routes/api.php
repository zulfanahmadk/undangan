<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishController;

Route::get('/wishes', [WishController::class, 'index']);
Route::post('/wishes', [WishController::class, 'store']);
