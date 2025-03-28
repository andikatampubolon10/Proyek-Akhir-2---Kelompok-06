<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\user;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::all();
        $user = auth()->user();
        return view('Role.Operator.Guru.index', compact('gurus', 'user'));
    }

    /**
     * Show the form for uploading Excel file.
     */
    public function upload()
    {
        return view('Role.Operator.Guru.index');
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Operator.Guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:gurus',
            'password' => 'required|string|min:6',
        ]);

        Guru::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'password' => bcrypt($request->password), 
        ]);

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gurus = Guru::findOrFail($id);
        return view('Role.Operator.Guru.index', compact('guru')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gurus = Guru::findOrFail($id);
        $user = auth()->user();
        return view('Role.Operator.Guru.edit', compact('gurus','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gurus = Guru::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:gurus,nip,' . $gurus->id,
            'password' => 'nullable|string|min:6',
        ]);

        $gurus->name = $request->name;
        $gurus->nip = $request->nip;

        if ($request->filled('password')) {
            $gurus->password = bcrypt($request->password);
        }

        $gurus->save();

        $user = User::findOrFail($gurus->user_id);

        $user->name = $request->name;
        $user->email = $request->nip;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gurus = Guru::findOrFail($id);
        $gurus->delete();

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}