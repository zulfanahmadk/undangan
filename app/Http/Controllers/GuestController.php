<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show(Guest $guest)
    {
        return view('index', [
            'guest' => $guest,
            'guestName' => $guest->name,
        ]);
    }
}
