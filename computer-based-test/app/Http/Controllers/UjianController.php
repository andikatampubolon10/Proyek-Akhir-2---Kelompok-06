<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Kursus;
use App\Models\Guru;
use App\Models\Tipe_Ujian;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UjianController extends Controller
{
    public function index()
    {
        $ujians = Ujian::with(['kursus', 'guru'])->orderBy('id_ujian', 'DESC')->get();
        $user = auth()->user();
        $courses = Kursus::with('guru')->get();
        $ujians = Ujian::all();
        $courses = Kursus::all();
        return view('Role.Guru.Course.index', compact('ujians', 'user', 'courses'));
    }

    public function create(Request $request)
    {
        $tipeUjians = Tipe_Ujian::all();
        $user = auth()->user();
        $week = $request->input('week');
        $courses = Kursus::all();
    
        if (!$courses) {
            return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
        }
    
        return view('Role.Guru.Course.Soal.create', compact('week','courses', 'tipeUjians', 'user'));
    }
    

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_ujian' => 'required|string|max:255|unique:ujian',
                'id_tipe_ujian' => 'required|exists:tipe_ujian,id_tipe_ujian',
                'Waktu_Mulai' => 'required|date_format:Y-m-d\TH:i',
                'Waktu_Selesai' => 'required|date_format:Y-m-d\TH:i|after:Waktu_Mulai',
                'acak' => 'required|in:Aktif,Tidak Aktif',
                'status_jawaban' => 'required|in:Aktif,Tidak Aktif',
                'grade' => 'required|numeric|min:0|max:100',
                'password' => 'required|string|min:8',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:40960',
                'week' => 'required|integer|min:1|max:26',
            ]);
    
            Log::info('Request Data: ', $request->all());

            // Ambil data guru dari pengguna yang sedang login
            $idUser  = auth()->user()->id;
            $guru = Guru::where('id_user', $idUser )->first();
    
            if (!$guru) {
                throw new \Exception('Guru tidak ditemukan untuk pengguna yang sedang login.');
            }
    
            // Ambil kursus yang dimiliki oleh guru
            $kursus = $guru->kursus()->first(); // Asumsi Anda memilih kursus pertama
            if (!$kursus) {
                throw new \Exception('Kursus tidak ditemukan untuk guru ini.');
            }
    
            $idKursus = $kursus->id_kursus;
    
            $week = $request->input('week'); // Ambil week dari input form
            Log::info('Menyimpan Ujian dengan week: ' . $week); // Debugging
    
            // Proses gambar jika ada
            $imageName = null;
            if ($request->hasFile('image')) {
                if (!$request->image->isValid()) {
                    throw new \Exception('Gambar yang diupload tidak valid.');
                }
    
                $imagePath = public_path('images/ujians');
                if (!is_dir($imagePath)) {
                    mkdir($imagePath, 0755, true);
                }
    
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move($imagePath, $imageName);
            }
    
            // Buat entitas Ujian
            $ujian = Ujian::create([
                'nama_ujian' => $validated['nama_ujian'],
                'id_tipe_ujian' => $validated['id_tipe_ujian'],
                'Waktu_Mulai' => $validated['Waktu_Mulai'],
                'Waktu_Selesai' => $validated['Waktu_Selesai'],
                'acak' => $validated['acak'],
                'status_jawaban' => $validated['status_jawaban'],
                'grade' => $validated['grade'],
                'week' => $week, // Menyimpan week yang diambil dari request
                'password' => Hash::make($validated['password']),
                'image' => $imageName,
                'id_kursus' => $idKursus,
                'id_guru' => $guru->id_guru,
            ]);
    
            return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error creating Ujian: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat membuat ujian. Silakan coba lagi.']);
        }
    }

    public function show(Ujian $ujian)
    {
        $course = $ujian->kursus;
        return view('Role.Guru.Course.index', compact('ujian', 'course'));
    }

    public function edit(Ujian $ujian)
    {
        return view('Role.Guru.Course.edit', compact('ujian'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'nama_ujian' => 'nullable|string|max:255',
            'acak' => 'nullable|in:Aktif,Tidak Aktif',
            'status_jawaban' => 'nullable|in:Aktif,Tidak Aktif',
            'grade' => 'nullable|numeric',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai',
            'Waktu_Lihat' => 'nullable|date',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kursus' => 'required|exists:kursuses,id_kursus',
            'id_guru' => 'required|exists:gurus,id_guru',
            'id_tipe_ujian' => 'required|exists:tipe_ujians,id_tipe_ujian',
        ]);

        if ($request->hasFile('Image')) {
            if ($ujian->Image) {
                Storage::disk('public')->delete($ujian->Image);
            }
            $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
        }

        $ujian->update($validated);

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        if ($ujian->Image) {
            Storage::disk('public')->delete($ujian->Image);
        }

        $ujian->delete();

        return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil dihapus.');
    }
}