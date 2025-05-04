<?php

namespace App\Http\Controllers;

use App\Models\Bisnis;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BisnisController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

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
        // Validasi input
        $request->validate([
            'nama_sekolah' => 'required|string|unique:bisnis',
            'jumlah_pendapatan' => 'required|numeric',  // Pastikan kolom ini selalu diisi
            'perjanjian' => 'required|file|mimes:pdf,doc,docx', // Validasi file perjanjian
        ]);
    
        // Memastikan file perjanjian di-upload
        if ($request->hasFile('perjanjian') && $request->file('perjanjian')->isValid()) {
            // Menyimpan file perjanjian ke storage
            $filePath = $request->file('perjanjian')->storeAs('perjanjian', time() . '_' . $request->file('perjanjian')->getClientOriginalName(), 'public');
        
            // Menyimpan data bisnis ke database termasuk path file perjanjian
            $bisnis = Bisnis::create([
                'nama_sekolah' => $request->nama_sekolah,
                'jumlah_pendapatan' => $request->jumlah_pendapatan,
                'perjanjian' => $filePath, // Menyimpan path file perjanjian
            ]);
    
            // Redirect ke index dengan pesan sukses
            return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dibuat dan perjanjian di-upload.');
        }
    
        // Jika file perjanjian tidak valid atau tidak ada file yang di-upload
        return redirect()->route('Admin.Bisnis.index')->with('error', 'Perjanjian tidak valid atau tidak ada file yang di-upload.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_bisnis)
{
    $bisnis = Bisnis::findOrFail($id_bisnis); // Mengambil data bisnis berdasarkan ID
    return view('Role.Admin.Bisnis.show', compact('bisnis'));
}

public function edit($id_bisnis)
{
    $bisnis = Bisnis::findOrFail($id_bisnis); // Mengambil data bisnis berdasarkan ID
    return view('Role.Admin.Bisnis.edit', compact('bisnis'));
}

public function update(Request $request, $id_bisnis)
{
    $request->validate([
        'nama_sekolah' => 'required|string|max:255',
        'jumlah_pendapatan' => 'required|numeric',
    ]);

    $bisnis = Bisnis::findOrFail($id_bisnis); // Mengambil data bisnis berdasarkan ID
    $bisnis->update($request->only(['nama_sekolah', 'jumlah_pendapatan']));

    return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil diupdate');
}

public function destroy($id_bisnis)
{
    $bisnis = Bisnis::findOrFail($id_bisnis); // Mengambil data bisnis berdasarkan ID
    $bisnis->delete(); // Menghapus data bisnis

    return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dihapus');
}

}
