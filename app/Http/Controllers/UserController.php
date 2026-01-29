<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Available roles in the system
     */
    private const AVAILABLE_ROLES = [
        ['id' => 'admin', 'name' => 'admin'],
        ['id' => 'user', 'name' => 'user'],
    ];

    /**
     * Display a listing of users
     */
    public function index()
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'This action is unauthorized.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $roles = self::AVAILABLE_ROLES;
        return view('admin.users', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'This action is unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return back()->with('success', 'Admin user berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan admin user: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'This action is unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
        ]);

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->username = $validated['username'];
            $user->role = $validated['role'];

            if ($validated['password']) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return back()->with('success', 'Admin user berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui admin user: ' . $e->getMessage());
        }
    }

    /**
     * Delete the specified user
     */
    public function destroy(User $user)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'This action is unauthorized.');
        }
        try {
            $userName = $user->name;
            $user->delete();
            return back()->with('success', "Admin user '$userName' berhasil dihapus");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus admin user: ' . $e->getMessage());
        }
    }
}
