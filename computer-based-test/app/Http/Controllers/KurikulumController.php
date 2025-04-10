<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Operator;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        $kurikulums = Kurikulum::all();
        $kurikulums = Kurikulum::with('operator')->get();
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kurikulum.index', compact('kurikulums', 'user'));
    }

    public function create()
    {
        $operators = Operator::all();
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kurikulum.create', compact('operators','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikulum',
        ]);

            $idUser   = auth()->user()->id;
            $operator = Operator::where('id_user', $idUser )->first();
    
        Kurikulum::create([
            'nama_kurikulum' => $request->nama_kurikulum,
            'id_operator' => $operator->id_operator,
        ]);
    
        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kurikulum = Kurikulum::with('operator')->findOrFail($id);
        $operator = Operator::all();
        return view('Role.Operator.Kurikulum.index', compact('kurikulum','operator'));
    }

    public function edit(string $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kurikulum.edit', compact('kurikulum', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikulum,nama_kurikulum,' . $id . ',id_kurikulum',
        ]);

        $id_operator = auth()->user()->id_operator;

        $idUser   = auth()->user()->id;
        $operator = Operator::where('id_user', $idUser )->first();

        $kurikulum = Kurikulum::findOrFail($id);

        $kurikulum->update([
            'nama_kurikulum' => $request->nama_kurikulum,
            'id_operator' => $operator->id_operator,
        ]);
    
        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }
}