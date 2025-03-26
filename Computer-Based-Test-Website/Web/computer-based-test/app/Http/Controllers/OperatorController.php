<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class OperatorController extends Controller
{
    public function index()
    {
        $users = User::role('operator')->get();
        return view('Role.Admin.Akun.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::where('name', 'operator')->first();
        return view('Role.Admin.Akun.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole('operator');

        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!$user->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('Role.Admin.Akun.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!$user->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }
        $role = Role::where('name', 'operator')->first();
        return view('Role.Admin.Akun.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!$user->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$user->hasRole('operator')) {
            abort(403, 'Unauthorized action.');
        }
        
        $user->delete();
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dihapus.');
    }
}