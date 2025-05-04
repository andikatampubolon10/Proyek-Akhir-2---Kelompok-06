<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kursus;
use App\Models\Guru;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $guru = Guru::where('id_user', $user->id)->first();
        if (!$guru) {
            return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
        }

        $materi = Materi::where('id_kursus', $guru->id_kursus) // Periksa apakah kursus sesuai
            ->where('id_guru', $guru->id_guru)  // Pastikan materi milik guru yang login
            ->orderBy('tanggal_materi', 'desc') // Urutkan berdasarkan tanggal materi terbaru
            ->get();

        return view('Role.Guru.Course.Materi.index', compact('materi', 'user'));
    }
    
    public function create(Request $request)
    {
        // Ambil data guru berdasarkan id_user
        $guru = Guru::where('id_user', auth()->user()->id)->first();

        // Cek jika guru tidak ditemukan
        if (!$guru) {
            return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
        }

        // Ambil kursus yang diajarkan oleh guru ini
        $kursus = Kursus::where('id_guru', $guru->id_guru)->get();

        // Pastikan kursus ada
        if ($kursus->isEmpty()) {
            return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
        }

        // Dapatkan data user
        $user = auth()->user();

        // Menampilkan form untuk tambah materi baru, dengan kursus yang terkait dengan guru
        return view('Role.Guru.Course.Materi.create', compact('kursus', 'user'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|mimes:pdf,docx,doc,ppt,pptx|max:10240', // Validasi file
            'id_kursus' => 'required|exists:kursus,id_kursus', // Validasi kursus
        ]);
    
        // Menyimpan file
        $filePath = $request->file('file')->store('public');
    
        try {
            // Mendapatkan data guru yang sedang login
            $guru = Guru::where('id_user', auth()->user()->id)->first();
    
            // Pastikan guru ditemukan
            if (!$guru) {
                return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
            }
    
            // Membuat materi baru
            Materi::create([
                'judul_materi' => $request->judul_materi,
                'deskripsi' => $request->deskripsi,
                'file' => $filePath,
                'tanggal_materi' => now(),
                'id_kursus' => $request->id_kursus,
                'id_guru' => $guru->id_guru, // Mengambil id_guru dari data guru yang ditemukan
            ]);
    
            return redirect()->route('Guru.Materi.index')->with('success', 'Materi berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing ujian: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan materi.']);
        }
    }
    

    // Menampilkan materi berdasarkan ID
    public function show($id)
    {
        $materi = Materi::findOrFail($id);
        return view('materi.show', compact('materi'));
    }

    // Menampilkan form untuk mengedit materi
    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        $courses = Kursus::all();
        return view('materi.edit', compact('materi', 'courses'));
    }

    // Mengupdate materi
    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        // Validasi input
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,docx,doc,ppt,pptx|max:10240', // Validasi file
        ]);

        // Update data materi
        $materi->judul_materi = $request->judul_materi;
        $materi->deskripsi = $request->deskripsi;

        // Jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($materi->file) {
                Storage::delete($materi->file);
            }

            // Simpan file baru
            $filePath = $request->file('file')->store('materi_files', 'public');
            $materi->file = $filePath;
        }

        $materi->save();

        return redirect()->route('Guru.Materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    // Menghapus materi
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Hapus file materi jika ada
        if ($materi->file) {
            Storage::delete($materi->file);
        }

        // Hapus materi dari database
        $materi->delete();

        return redirect()->route('Guru.Materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
