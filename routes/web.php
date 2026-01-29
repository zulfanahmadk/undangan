<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Guest;

// Temporary migration route
Route::get('/setup/migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate');
        return 'Migration berhasil dijalankan! Redirect ke <a href="/admin/dashboard">dashboard</a>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected with auth middleware)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [GuestController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/guests', [GuestController::class, 'guests'])->name('admin.guests');
    Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::get('/guests/{id}', [GuestController::class, 'edit'])->name('guests.edit')->where('id', '\d+');
    Route::put('/guests/{id}', [GuestController::class, 'update'])->name('guests.update')->where('id', '\d+');
    Route::delete('/guests/{id}', [GuestController::class, 'destroy'])->name('guests.destroy')->where('id', '\d+');

    // User management routes
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/', function () {
    $guestSlug = request('to');
    $guest = null;
    $guestName = 'Keluarga Besar H. Emor Atmadidjaja';

    if ($guestSlug) {
        $guest = Guest::where('slug', $guestSlug)->first();
        if ($guest) {
            $guestName = $guest->name;
        } else {
            $guestName = $guestSlug;
        }
    }

    return view('index', [
        'guest' => $guest,
        'guestName' => $guestName,
    ]);
});

Route::get('/{guest}', [GuestController::class, 'show']);
