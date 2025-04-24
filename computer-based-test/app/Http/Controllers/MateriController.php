<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kursus;
use App\Models\User;
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
        $courses = Kursus::all();
        $courses = Kursus::with('guru')->get();
        $materi = Materi::where('id_kursus', $user->id_kursus) 
            ->where('id_guru', $user->id_guru)  
            ->orderBy('id_materi', 'DESC')
            ->get();
        $materi = Materi::all();
    
        return view('Role.Guru.Course.Materi.index', compact('materi', 'user','courses'));
    }
    
    public function create(Request $request)
    {
        $user = auth()->user();
        $courses = Kursus::all();
        $week = $request->get('week'); // Ambil week dari parameter URL atau form
    
        if (!$courses) {
            return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
        }
        return view('Role.Guru.Course.Materi.create', compact('user', 'week', 'courses'));
    }
    
    public function store(Request $request)
    {
        Log::info('Menerima request untuk membuat materi.');
    
        // Validasi input
        $validated = $request->validate([
            'judul_materi' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx', // Validasi file yang di-upload
            'week' => 'required|integer|min:1|max:26', // Validasi untuk week
            'deskripsi' => 'required|string|max:1000',
        ]);
    
        // Ambil data guru dari pengguna yang sedang login
        $idUser  = auth()->user()->id;
        $guru = Guru::where('id_user', $idUser)->first();
    
        if (!$guru) {
            Log::error('Guru tidak ditemukan untuk pengguna yang sedang login.');
            throw new \Exception('Guru tidak ditemukan untuk pengguna yang sedang login.');
        }
    
        // Ambil kursus yang dimiliki oleh guru
        $kursus = $guru->kursus()->first();
        if (!$kursus) {
            Log::error('Kursus tidak ditemukan untuk guru ini.');
            throw new \Exception('Kursus tidak ditemukan untuk guru ini.');
        }
    
        $idKursus = $kursus->id_kursus;
    
        $week = $request->input('week'); // Ambil week dari input form
        Log::info('Menyimpan Materi dengan week: ' . $week);
    
        // Proses upload file jika ada
        $filePath = $request->file('file')->store('materi', 'public');
        Log::info('File berhasil diupload.', ['file_path' => $filePath]);
    
        // Simpan materi
        Materi::create([
            'judul_materi' => $request->judul_materi,
            'deskripsi' => $request->deskripsi,
            'week' => $week, // Menyimpan week
            'file' => $filePath, // Menyimpan path file
            'id_kursus' => $idKursus,
            'id_guru' => Auth::user()->guru->id_guru, // Asumsi bahwa pengguna yang login adalah guru
        ]);
    
        Log::info('Materi berhasil disimpan.');
    
        return redirect()->route('Guru.Materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }
        

    public function show($id)
    {
        $materi = Materi::findOrFail($id);
        return view('materi.show', compact('materi'));
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::delete($materi->file_path);
            // Simpan file baru
            $filePath = $request->file('file')->store('materi');
            $materi->file_path = $filePath;
        }

        $materi->judul_materi = $request->judul_materi;
        $materi->deskripsi = $request->deskripsi;
        $materi->save();

        return redirect()->route('materi.index', $materi->id_kursus)->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        // Hapus file dari storage
        Storage::delete($materi->file_path);
        // Hapus data materi
        $materi->delete();

        return redirect()->route('materi.index', $materi->id_kursus)->with('success', 'Materi berhasil dihapus.');
    }
}