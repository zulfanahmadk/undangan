<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Models\Guest;

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
