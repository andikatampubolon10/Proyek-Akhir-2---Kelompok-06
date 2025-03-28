<?php

namespace App\Http\Controllers;

use App\Models\Bisnis;
use Illuminate\Http\Request;
use App\Models\User;

class BisnisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bisnises = Bisnis::all();
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
    
        Bisnis::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'jumlah_pendapatan' => $request->jumlah_pendapatan,
        ]);
    
        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        return view('Role.Admin.Bisnis.index', compact('bisnis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        return view('Role.Admin.Bisnis.edit', compact('bisnis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis,username,' . $id,
            'jumlah_pendapatan' => 'required|numeric',
        ]);
        $bisnis = Bisnis::findOrFail($id);
        $bisnis->nama = $request->nama; 
        $bisnis->username = $request->username;
        $bisnis->jumlah_pendapatan = $request->jumlah_pendapatan;
    
        $bisnis->save();
    
        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        $bisnis->delete();
        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis Berhasil dihapus');
    }
}