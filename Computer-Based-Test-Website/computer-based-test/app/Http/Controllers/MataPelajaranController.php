<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\user;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $mataPelajarans = MataPelajaran::with(['kurikulum', 'user'])->get();
        return view('Role.Operator.Mapel.index', compact('mataPelajarans', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurikulum = Kurikulum::all(); 
        $user = auth()->user();
        return view('Role.Operator.Mapel.create',compact('user','kurikulum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_pelajaran' => 'required|unique:mata_pelajarans',
            'kurikulum_id' => 'required|exists:kurikulums,id',
        ]);

        MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'user_id' => auth()->id(), 
            'kurikulum_id' => 'required|exists:kurikulums,id',
        ]);

        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataPelajaran $mataPelajaran)
    {
        return view('Role.Operator.Mapel.index', compact('mataPelajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('Role.Operator.Mapel.edit', compact('mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mata_pelajaran' => 'required|unique:mata_pelajarans,nama_mata_pelajaran,' . $mataPelajaran->id,
            'kurikulum_id' => 'required|exists:kurikulums,id',
        ]);

        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->update([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kurikulum_id' => $request->kurikulum_id,
        ]);

        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran deleted successfully.');
    }
}