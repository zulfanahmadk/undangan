<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function dashboard()
    {
        $totalGuests = Guest::count();
        $totalWishes = \App\Models\Wish::count();
        $guestsToday = Guest::whereDate('created_at', today())->count();
        $recentGuests = Guest::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.index', [
            'totalGuests' => $totalGuests,
            'totalWishes' => $totalWishes,
            'guestsToday' => $guestsToday,
            'recentGuests' => $recentGuests,
        ]);
    }

    public function guests(\Illuminate\Http\Request $request)
    {
        $query = Guest::orderBy('created_at', 'desc');
        $statusFilter = $request->query('status');

        if ($statusFilter && in_array($statusFilter, ['1', '2'])) {
            $query->where('status', (int)$statusFilter);
        }

        $guests = $query->paginate(15);

        // Calculate status counts
        $statusCounts = [
            'sent' => Guest::where('status', 1)->count(),
            'pending' => Guest::where('status', 2)->count(),
            'total' => Guest::count(),
        ];

        return view('admin.guests', [
            'guests' => $guests,
            'statusCounts' => $statusCounts,
            'activeFilter' => $statusFilter,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|regex:/^62\d{9,12}$/',
        ], [
            'name.required' => 'Nama Tamu wajib diisi',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'whatsapp.regex' => 'Nomor WhatsApp tidak valid. Format: 6282216210360 (9-12 digit)',
        ]);

        try {
            // Find the next available ID (fill gaps from deleted records)
            $nextId = $this->findNextAvailableId();

            Guest::create([
                'id' => $nextId,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'whatsapp' => $validated['whatsapp'],
            ]);

            return redirect()->route('admin.guests')->with('success', 'Guest berhasil ditambahkan');
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'whatsapp') !== false) {
                return redirect()->route('admin.guests')->with('error', 'Database belum terupdate. Kunjungi <a href="/setup/migrate">setup migration</a>');
            }
            throw $e;
        }
    }

    /**
     * Find the next available ID (fills gaps from deleted records)
     * Always returns the smallest available ID starting from 1
     */
    private function findNextAvailableId()
    {
        // Get all existing IDs, convert to array and sort numerically
        $existingIds = Guest::orderBy('id')->pluck('id')->toArray();

        // If no guests exist, start from 1
        if (empty($existingIds)) {
            return 1;
        }

        // Find the first gap in the sequence starting from 1
        $id = 1;
        foreach ($existingIds as $existingId) {
            if ($existingId == $id) {
                $id++;
            } else if ($existingId > $id) {
                // Found a gap
                return $id;
            }
        }

        // If no gaps found, return next sequential ID after the last one
        return $id;
    }

    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        return view('admin.edit-guest', ['guest' => $guest]);
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);

        // Handle JSON requests (status update from AJAX)
        if ($request->expectsJson() || $request->isJson() || $request->has('status')) {
            $validated = $request->validate([
                'status' => 'required|integer|in:1,2',
            ]);

            $guest->update([
                'status' => $validated['status'],
            ]);

            return response()->json(['success' => true, 'status' => $guest->status]);
        }

        // Handle form submissions (name and whatsapp update)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|regex:/^62\d{9,12}$/',
        ], [
            'name.required' => 'Nama Tamu wajib diisi',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'whatsapp.regex' => 'Nomor WhatsApp tidak valid. Format: 6282216210360 (9-12 digit)',
        ]);

        $guest->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'whatsapp' => $validated['whatsapp'],
        ]);

        return redirect()->route('admin.guests')->with('success', 'Guest berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();
        return redirect()->route('admin.guests')->with('success', 'Guest berhasil dihapus');
    }

    public function show(Guest $guest)
    {
        return view('index', [
            'guest' => $guest,
            'guestName' => $guest->name,
        ]);
    }

    public function wishes()
    {
        $wishes = \App\Models\Wish::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.wishes', ['wishes' => $wishes]);
    }
}
