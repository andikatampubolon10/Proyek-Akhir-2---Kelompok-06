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
        $bisnis = Bisnis::all();
        return view('bisnis.index', compact('bisnis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bisnis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis',
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        Bisnis::create($request->all());
        return redirect()->route('bisnis.index')->with('success', 'Bisnis created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        return view('bisnis.show', compact('bisnis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        return view('bisnis.edit', compact('bisnis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis,username,' . $id,
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        $bisnis = Bisnis::findOrFail($id);
        $bisnis->update($request->all());
        return redirect()->route('bisnis.index')->with('success', 'Bisnis updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bisnis = Bisnis::findOrFail($id);
        $bisnis->delete();
        return redirect()->route('bisnis.index')->with('success', 'Bisnis deleted successfully.');
    }
}