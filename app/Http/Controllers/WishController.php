<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function index()
    {
        $wishes = Wish::latest()->get();
        return response()->json(['wishes' => $wishes]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string|max:1000',
        ]);

        $wish = Wish::create($validated);

        return response()->json([
            'message' => 'Ucapan berhasil disimpan',
            'wish' => $wish
        ], 201);
    }
}
