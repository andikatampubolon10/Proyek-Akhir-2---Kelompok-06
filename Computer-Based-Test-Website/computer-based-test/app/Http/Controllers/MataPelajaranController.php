<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MataPelajaranController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080/', 
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $response = $this->client->get('mata-pelajaran');
        $mataPelajarans = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Mapel.index', compact('mataPelajarans', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurikulum = Kurikulum::all(); 
        $user = auth()->user();
        return view('Role.Operator.Mapel.create', compact('user', 'kurikulum'));
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

        $response = $this->client->post('mata-pelajaran', [
            'json' => [
                'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
                'user_id' => auth()->id(),
                'kurikulum_id' => $request->kurikulum_id,
            ]
        ]);

        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("mata-pelajaran/{$id}");
        $mataPelajaran = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Mapel.show', compact('mataPelajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("mata-pelajaran/{$id}");
        $mataPelajaran = json_decode($response->getBody()->getContents(), true)['data'];
        $kurikulum = Kurikulum::all();
        return view('Role.Operator.Mapel.edit', compact('mataPelajaran', 'kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_mata_pelajaran' => 'required|unique:mata_pelajarans,nama_mata_pelajaran,' . $id,
            'kurikulum_id' => 'required|exists:kurikulums,id',
        ]);

        $response = $this->client->put("mata-pelajaran/{$id}", [
            'json' => [
                'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
                'kurikulum_id' => $request->kurikulum_id,
            ]
        ]);

        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("mata-pelajaran/{$id}");
        return redirect()->route('Operator.MataPelajaran.index')
            ->with('success', 'Mata Pelajaran deleted successfully.');
    }
}