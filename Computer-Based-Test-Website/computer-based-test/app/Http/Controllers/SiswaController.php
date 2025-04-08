<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\user;
use App\Models\Kelas;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Siswa.index', compact('siswa', 'user', 'kelas'));
    }

    /**
     * Show the form for uploading Excel file.
     */
    public function upload()
    {
        return view('Role.Operator.Siswa.index');
    }

    /**
     * Handle the Excel file upload.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                Excel::import(new SiswaImport, $request->file('file'));
                return redirect()->route('Operator.Siswa.index')->with('success', 'Data siswa berhasil diupload.');
            } catch (\Exception $e) {
                \Log::error('Error during import: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau gagal diupload.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Operator.Siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswa',
            'password' => 'required|string|min:6',
        ]);

        Siswa::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'password' => bcrypt($request->password), 
        ]);

        return redirect()->route('Operator.Siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('Role.Operator.Siswa.index', compact('siswa')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = auth()->user();
        return view('Role.Operator.Siswa.edit', compact('siswa', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:siswa,nis,' . $siswa->id,
            'password' => 'nullable|string|min:6',
        ]);

        $siswa->name = $request->name;
        $siswa->nis = $request->nis;
    
        if ($request->filled('password')) {
            $siswa->password = bcrypt($request->password);
        }
    
        $siswa->save();

        $user = User::findOrFail($siswa->user_id);

        $user->name = $request->name;
        $user->email = $request->nis;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();

        return redirect()->route('Operator.Siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('Operator.Siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}