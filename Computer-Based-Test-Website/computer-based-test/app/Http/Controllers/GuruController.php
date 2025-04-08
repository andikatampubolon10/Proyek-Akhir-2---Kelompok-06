<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080/', // Ganti dengan URL API Go Anda
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->client->get('gurus');
        $gurus = json_decode($response->getBody()->getContents(), true)['data'];
        $user = auth()->user();
        return view('Role.Operator.Guru.index', compact('gurus', 'user'));
    }

    /**
     * Show the form for uploading Excel file.
     */
    public function upload()
    {
        return view('Role.Operator.Guru.index');
    }

    /**
     * Handle the Excel file upload.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                // Menggunakan Maatwebsite Excel untuk membaca file
                $data = Excel::toArray(new GuruImport, $request->file('file'))[0];

                $gurus = [];
                foreach ($data as $row) {
                    $gurus[] = [
                        'name' => $row[0],
                        'nip' => $row[1],
                        'password' => $row[2],
                    ];
                }
                $response = $this->client->post('import-gurus', [
                    'json' => $gurus
                ]);
    
                return redirect()->route('Operator.Guru.index')->with('success', 'Data guru berhasil diupload.');
            } catch (\Exception $e) {
                \Log::error('Error during import: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid atau gagal diupload.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Operator.Guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:gurus',
            'password' => 'required|string|min:6',
        ]);

        $response = $this->client->post('gurus', [
            'json' => [
                'name' => $request->name,
                'nip' => $request->nip,
                'password' => bcrypt($request->password),
            ]
        ]);

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("gurus/{$id}");
        $guru = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Operator.Guru.show', compact('guru')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("gurus/{$id}");
        $guru = json_decode($response->getBody()->getContents(), true)['data'];
        $user = auth()->user();
        return view('Role.Operator.Guru.edit', compact('guru', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:gurus,nip,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $guruData = [
            'name' => $request->name,
            'nip' => $request->nip,
        ];

        if ($request->filled('password')) {
            $guruData['password'] = bcrypt($request->password);
        }

        $response = $this->client->put("gurus/{$id}", [
            'json' => $guruData
        ]);

        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("gurus/{$id}");
        return redirect()->route('Operator.Guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}