<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $roles = Role::all();
        $users = User::with('roles')->get();
        return view('users.index', compact('users', 'roles'));
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        // return view('users.create', compact('roles'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        foreach ($request->roles as $roleId) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Menampilkan detail user
    public function show(User $user)
    {
        // return view('users.show', compact('user'));
    }

    // Menampilkan form untuk mengedit user
    public function edit(User $user)
    {
        // $roles = Role::all();
        // return view('users.edit', compact('user', 'roles'));
    }

    // Mengupdate user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        UserRole::where('user_id', $user->id)->delete();
        foreach ($request->roles as $roleId) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}