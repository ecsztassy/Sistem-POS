<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::withCount('transactions')->orderBy('name')->get()]);
    }

    public function create()
    {
        return view('users.form', ['user' => new User]);
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return to_route('users.index')->with('success', 'Pengguna ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.form', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        if ($user->id === auth()->id() && $request->validated('role') !== 'admin') {
            return back()->withErrors(['role' => 'Anda tidak dapat menurunkan peran akun sendiri.']);
        }
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);

        return to_route('users.index')->with('success', 'Pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id() || $user->transactions()->exists()) {
            return back()->withErrors(['user' => 'Akun sendiri atau akun dengan riwayat transaksi tidak dapat dihapus.']);
        }
        $user->delete();

        return back()->with('success', 'Pengguna dihapus.');
    }
}
