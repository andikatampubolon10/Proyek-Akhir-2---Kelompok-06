<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Operator; 
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8080/',
        ]);
        $response = $this->client->get('Admin/Akun');
        $data = json_decode($response->getBody()->getContents(), true);
    }
    

    public function index()
    {
        $response = $this->client->get('Admin/Akun');
        $users = auth()->user();
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['data'])) {
            $operators = $data['data'];
        } else {
            $operators = [];
        }
    
        return view('Role.Admin.Akun.index', compact('operators', 'users'));
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
            'nama_sekolah' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'durasi' => 'integer',
        ]);
        $durasi = $request->durasi ?? 12;
    
        Operator::create([
            'nama_sekolah' => $request->nama_sekolah,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'durasi' => $durasi, 
        ]);

        $user = User::create([
            'name' => $request->nama_sekolah,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('Operator');
    
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("operators/{$id}");
        $data = json_decode($response->getBody()->getContents(), true);
        dd($data);
    
        $operator = $data['data'];
        return view('Role.Admin.Akun.show', compact('operator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("Admin/Akun/");
        $users = auth()->user();
        $data = json_decode($response->getBody()->getContents(), true);
    
        $operators = null;
        if (isset($data['data'])) {
            foreach ($data['data'] as $item) {
                if ($item['id'] == $id) {
                    $operators = $item;
                    break;
                }
            }
        }
    
        return view('Role.Admin.Akun.edit', compact('operators', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info("Updating operator with ID: {$id}");
    
        $request->validate([
            'nama_sekolah' => 'nullable|string|max:255', // Ubah menjadi nullable
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id, // Ubah menjadi nullable
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $operator = Operator::findOrFail($id);
    
        $user = User::where('email', $operator->email)->first();
    
        $operator->update([
            'nama_sekolah' => $request->filled('nama_sekolah') ? $request->nama_sekolah : $operator->nama_sekolah,
            'email' => $request->filled('email') ? $request->email : $operator->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $operator->password,
        ]);

        if ($user) {
            $user->update([
                'name' => $request->filled('nama_sekolah') ? $request->nama_sekolah : $user->name,
                'email' => $request->filled('email') ? $request->email : $user->email,
                'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            ]);
        } else {
            Log::warning("User not found for operator ID: {$id}");
        }
    
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("operators/{$id}");
        return redirect()->route('Admin.Akun.index')->with('success', 'Akun operator berhasil dihapus.');
    }
}