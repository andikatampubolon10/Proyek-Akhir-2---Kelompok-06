<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Operator;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('operator')->get();
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kelas.index', compact('kelas', 'user'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('Role.Operator.Kelas.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas',
        ]);

        $idUser  = auth()->id();
        $operator = Operator::where('id_user', $idUser )->first();

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_operator' => $operator->id_operator,
        ]);

        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kelas = Kelas::with('operator')->findOrFail($id);
        return view('Role.Operator.Kelas.show', compact('kelas'));
    }

    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $user = auth()->user();
        return view('Role.Operator.Kelas.edit', compact('kelas', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id . ',id_kelas',
        ]);
    
        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);
    
        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
    
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}