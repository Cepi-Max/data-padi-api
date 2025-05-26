<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $roles = ['admin', 'petani', 'pembeli']; // tambah jika ada role lain
        return view('admin.users.index', compact('users', 'roles'));
    }

    // Tampilkan form edit role
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'petani', 'pembeli'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Proses update role
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,petani,pembeli'
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Role pengguna berhasil diupdate!');
    }
}
