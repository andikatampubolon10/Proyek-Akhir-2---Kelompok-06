<?php

namespace App\Http\Controllers;

use App\Models\Bisnis;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BisnisController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080/',
        ]);
    }

    public function index()
    {
        $response = $this->client->get('bisnis');
        $bisnises = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Admin.Bisnis.index', compact('bisnises'));
    }

    public function create()
    {
        return view('Role.Admin.Bisnis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis',
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        $response = $this->client->post('bisnis', [
            'json' => $request->only(['nama', 'username', 'jumlah_pendapatan'])
        ]);

        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dibuat');
    }

    public function show(string $id)
    {
        $response = $this->client->get("bisnis/{$id}");
        $bisnis = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Admin.Bisnis.show', compact('bisnis'));
    }

    public function edit(string $id)
    {
        $response = $this->client->get("bisnis/{$id}");
        $bisnis = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Admin.Bisnis.edit', compact('bisnis'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:bisnis,username,' . $id,
            'jumlah_pendapatan' => 'required|numeric',
        ]);

        $response = $this->client->put("bisnis/{$id}", [
            'json' => $request->only(['nama', 'username', 'jumlah_pendapatan'])
        ]);

        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $response = $this->client->delete("bisnis/{$id}");
        return redirect()->route('Admin.Bisnis.index')->with('success', 'Bisnis berhasil dihapus');
    }
}