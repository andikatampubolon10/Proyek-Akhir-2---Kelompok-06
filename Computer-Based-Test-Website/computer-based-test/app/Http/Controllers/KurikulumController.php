<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class KurikulumController extends Controller
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
        $response = $this->client->get('kurikulum');
        $kurikulums = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Kurikulum.index', compact('kurikulums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Operator.Kurikulum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikulums',
            'user_id' => 'required|exists:users,id',
        ]);

        $response = $this->client->post('kurikulum', [
            'json' => $request->only(['nama_kurikulum', 'user_id'])
        ]);

        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("kurikulum/{$id}");
        $kurikulum = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Kurikulum.show', compact('kurikulum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("kurikulum/{$id}");
        $kurikulum = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255|unique:kurikulums,nama_kurikulum,' . $id,
            'user_id' => 'required|exists:users,id',
        ]);

        $response = $this->client->put("kurikulum/{$id}", [
            'json' => $request->only(['nama_kurikulum', 'user_id'])
        ]);

        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("kurikulum/{$id}");
        return redirect()->route('Operator.Kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }
}