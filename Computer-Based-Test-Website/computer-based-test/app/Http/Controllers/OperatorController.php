<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Operator; 
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OperatorController extends Controller
{
    public function index()
    {
        $users = User::role('Operator')->get();
        return view('Role.Admin.Akun.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::where('name', 'Operator')->first();
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
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        \Log::info('Assigning role Operator to user:', ['id' => $user->id]);
    
        $user->assignRole('Operator');

        \Log::info('Role assigned:', ['roles' => $user->getRoleNames()->toArray()]);
    
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!$user->hasRole('Operator')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('Role.Admin.Akun.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        \Log::info('User yang sedang login:', [
            'id' => auth()->user()->id,
            'roles' => auth()->user()->getRoleNames()->toArray(),
        ]);
    
        \Log::info('User yang sedang diakses:', [
            'id' => $user->id,
            'roles' => $user->getRoleNames()->toArray(),
        ]);

        if (!auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        if (!$user->hasRole('Operator')) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('Role.Admin.Akun.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        if (!$user->hasRole('Operator')) {
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
    public function destroy($id)
    {
$user = User::find($id);

if (!$user) {
    return response()->massage(['message' => 'User  not found'], 404);
}
$user->delete();
    
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dihapus.');
    }
}