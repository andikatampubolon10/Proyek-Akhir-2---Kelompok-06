<?php

namespace App\Http\Controllers;

use App\Models\BisnisOperator;
use Illuminate\Http\Request;

class BisnisOperatorController extends Controller
{
    public function index()
    {
        $businesses = BisnisOperator::all();
        return view('admin.bisnisDashboard', compact('businesses'));
    }

    public function create()
    {
        return view('admin.createBisnis');
    }

    public function destroy(BisnisOperator $bisnis)
    {
        $bisnis->delete();
        return redirect()->route('admin.bisnisDashboard')->with('success', 'Data berhasil dihapus');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'revenue' => 'required|numeric|min:0',
        ]);

        $cleanRevenue = str_replace(['Rp', '.', ','], '', $request->revenue);
        
        BisnisOperator::create([
            'name' => $validated['name'],
            'revenue' => (float)$cleanRevenue,
        ]);

        return redirect()->route('admin.bisnisDashboard')->with('success', 'Data berhasil ditambahkan');
    }
}