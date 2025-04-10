<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Operator;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->get();
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Guru.index', compact('gurus', 'user'));
    }

    public function upload()
    {
        return view('Role.Operator.Guru.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                Excel::import(new GuruImport, $request->file('file'));
                return redirect()->route('Operator.Guru.index')->with('success', 'Data guru berhasil diupload.');
            } catch (\Exception $e) {
                \Log::error('Error during import: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau gagal diupload.');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Guru.create',compact('user'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'nip' => 'required|string|max:255|unique:gurus',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'status' => 'in:Aktif,Tidak Aktif',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole('Guru');
    
            $idUser   = auth()->user()->id;
            $operator = Operator::where('id_user', $idUser )->first();
    
            if (!$operator) {
                Log::error('Operator not found for user: ' . $idUser );
                return redirect()->back()->withErrors('ID Operator tidak ditemukan. Pastikan pengguna memiliki ID Operator yang valid.');
            }
    
            Guru::create([
                'nama_guru' => $request->name,
                'nip' => $request->nip,
                'id_user' => $user->id,
                'id_operator' => $operator->id_operator,
                'status' => $request->status ?? 'Aktif',
            ]);

    
            return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error adding guru: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->withErrors('Terjadi kesalahan saat menambahkan guru.');
        }
    }

    public function show(string $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('Role.Operator.Guru.index', compact('guru'));
    }

    public function edit(string $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $user = auth()->user();
        return view('Role.Operator.Guru.edit', compact('guru', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:gurus,nip,' . $id,
            'password' => 'nullable|string|min:6',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->nama_guru = $request->name;
        $guru->nip = $request->nip;
        $guru->nip = $request->status;

        if ($request->filled('password')) {
            $guru->password = bcrypt($request->password);
        }

        $guru->save();

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}