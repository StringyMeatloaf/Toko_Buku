<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        $totalAdmins = User::count();

        $activeUsers = User::where('is_active', true)
            ->count();

        return view(
            'master-data.users.index',
            compact(
                'users',
                'totalAdmins',
                'activeUsers'
            )
        );
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'role' => 'required',
        'is_active' => 'required'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_active' => $request->is_active
    ]);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Pengguna berhasil ditambahkan'
        );
}
public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required',
        'is_active' => 'required'
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'is_active' => $request->is_active,
    ];

    if ($request->filled('password'))
    {
        $data['password'] = Hash::make(
            $request->password
        );
    }

    $user->update($data);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Pengguna berhasil diperbarui'
        );
}
public function destroy(User $user)
{
    // Using Auth::id() instead of auth()->id()
    if ($user->id == Auth::id()) 
    {
        return redirect()
            ->route('users.index')
            ->with(
                'error',
                'Tidak dapat menghapus akun yang sedang digunakan'
            );
    }

    $user->delete();

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Pengguna berhasil dihapus'
        );
}

}