<?php

namespace App\Http\Controllers;

use App\Models\Bisnis;
use Illuminate\Http\Request;

class BisnisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bisnises = Bisnis::all(); // Mengambil semua data bisnis dari database
        return view('Role.Admin.Bisnis.index', compact('bisnises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Admin.Bisnis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis',
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        Bisnis::create($request->only(['nama', 'username', 'jumlah_pendapatan']));

        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bisnis = Bisnis::findOrFail($id); // Mengambil data bisnis berdasarkan ID
        return view('Role.Admin.Bisnis.show', compact('bisnis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bisnis = Bisnis::findOrFail($id); // Mengambil data bisnis berdasarkan ID
        return view('Role.Admin.Bisnis.edit', compact('bisnis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis,username,' . $id,
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        $bisnis = Bisnis::findOrFail($id); // Mengambil data bisnis berdasarkan ID
        $bisnis->update($request->only(['nama', 'username', 'jumlah_pendapatan']));

        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bisnis = Bisnis::findOrFail($id); // Mengambil data bisnis berdasarkan ID
        $bisnis->delete(); // Menghapus data bisnis

        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dihapus');
    }
}