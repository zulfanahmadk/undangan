<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $this->authorize('admin');

        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::all();
        return view('admin.users', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role yang dipilih tidak valid',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Attach role to user
            $user->roles()->attach($validated['role_id']);

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
        $this->authorize('admin');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role yang dipilih tidak valid',
        ]);

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if ($validated['password']) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Update user roles
            $user->roles()->sync([$validated['role_id']]);

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
        $this->authorize('admin');
        try {
            $userName = $user->name;
            $user->delete();
            return back()->with('success', "Admin user '$userName' berhasil dihapus");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus admin user: ' . $e->getMessage());
        }
    }
}
