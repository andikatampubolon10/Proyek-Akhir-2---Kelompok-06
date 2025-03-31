<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class KelasController extends Controller
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
        $response = $this->client->get('kelas');
        $kelas = json_decode($response->getBody()->getContents(), true)['data'];
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kelas.index', compact('kelas', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('Role.Operator.Kelas.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas',
        ]);

        $response = $this->client->post('kelas', [
            'json' => [
                'nama_kelas' => $request->nama_kelas,
                'user_id' => auth()->id(),
            ]
        ]);

        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("kelas/{$id}");
        $kelas = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("kelas/{$id}");
        $kelas = json_decode($response->getBody()->getContents(), true)['data'];
        $user = auth()->user();
        return view('Role.Operator.Kelas.edit', compact('kelas', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
        ]);

        $response = $this->client->put("kelas/{$id}", [
            'json' => [
                'nama_kelas' => $request->nama_kelas,
            ]
        ]);

        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("kelas/{$id}");
        return redirect()->route('Operator.Kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}