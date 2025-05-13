<?php

namespace App\Http\Controllers;

use App\Models\Latihan;
use App\Models\kurikulum;
use App\Models\mata_pelajaran;
use App\Models\Soal;
use App\Models\Guru;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LatihanSoalController extends Controller
{
    public function index(Request $request)
    {
        $latihan = Latihan::orderBy('id_latihan', 'DESC')->get();
        $id_latihan = $request->query('id_latihan');
        $kurikulums = kurikulum::all();
        $mapel = mata_pelajaran::all();
        $mataPelajarans = mata_pelajaran::with(['operator', 'kurikulum'])->get();
        $kelas = Kelas::all();
        $user = auth()->user();

        return view('Role.Guru.Latihan.index', compact('latihan','mataPelajarans', 'user', 'kurikulums', 'mapel', 'kelas', 'id_latihan'));
    }

    public function create(Request $request)
    {
        $id_kurikulum = $request->input('id_kurikulum');
    
        // Get all kurikulum and classes
        $kurikulums = Kurikulum::all();
        $kelas = Kelas::all();
        $user = auth()->user();
    
        // If a kurikulum is selected, get the first mata pelajaran that matches
        if ($id_kurikulum) {
            $mapel = mata_pelajaran::where('id_kurikulum', $id_kurikulum)->first();
        } else {
            $mapel = null;
        }

        $mataPelajarans = mata_pelajaran::with(['operator', 'kurikulum'])->get();
    
        // Return the view with the selected mata pelajaran and other data
        return view('Role.Guru.Latihan.create', compact('mataPelajarans','mapel', 'kurikulums', 'kelas', 'user'));
    }
    

    public function store(Request $request)
    {
        // Log the request data to check if everything is correct
        Log::info('Request data:', $request->all());

        // Validasi input
        $validated = $request->validate([
            'Topik' => 'required|string|max:255',
            'id_kurikulum' => 'required|exists:kurikulum,id_kurikulum',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'acak' => 'required|in:Aktif,Tidak Aktif',
            'status_jawaban' => 'required|in:Aktif,Tidak Aktif',
            'grade' => 'required|integer',
        ]);

        // Log the validated data
        Log::info('Validated data:', $validated);

        $idUser   = auth()->user()->id;
        $guru = Guru::where('id_user', $idUser)->first();

        if (!$guru) {
            throw new \Exception('Guru tidak ditemukan untuk pengguna yang sedang login.');
        }
        // Menyimpan data latihan
        $latihan = latihan::create([
            'Topik' => $validated['Topik'],
            'acak' => $validated['acak'],
            'status_jawaban' => $validated['status_jawaban'],
            'grade' => $validated['grade'],
            'id_guru' => $guru->id_guru,
            'id_kurikulum' => $validated['id_kurikulum'],
            'id_mata_pelajaran' => $validated['id_mata_pelajaran'],
            'id_kelas' => $validated['id_kelas'],
        ]);

        // Log the created `latihan` object
        Log::info('Latihan created:', ['id_latihan' => $latihan->id]);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('Guru.Latihan.index')->with('success', 'Latihan berhasil dibuat.');
    }

    public function show(Latihan $latihanSoal)
    {
        return view('Role.Guru.Latihan.index', compact('latihanSoal'));
    }

    public function edit(Latihan $latihanSoal)
    {
        return view('Role.Guru.Latihan.edit', compact('latihanSoal'));
    }

    public function update(Request $request, LatihanSoal $latihanSoal)
    {
        $validated = $request->validate([
            'Nilai' => 'required|integer',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
            'kurikulum_id' => 'required|exists:kurikulums,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('Image')) {
            if ($latihanSoal->Image) {
                Storage::disk('public')->delete($latihanSoal->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/latihan_soals', 'public');
        }

        $latihanSoal->update($validated);

        return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal updated successfully.');
    }

    public function destroy(LatihanSoal $latihanSoal)
    {
        if ($latihanSoal->Image) {
            Storage::disk('public')->delete($latihanSoal->Image);
        }

        $latihanSoal->delete();

        return redirect()->route('Guru.LatihanSoal.index')->with('success', 'Latihan Soal deleted successfully.');
    }
}
