<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Kursus;
use App\Models\Guru;
use App\Models\Tipe_Ujian;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UjianController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data user yang sedang login
        $user = auth()->user();  
        
        if (!$user) {
            return redirect()->route('login'); // Redirect jika user tidak ditemukan
        }
    
        $guru = Guru::where('id_user', $user->id)->first();
    
        if (!$guru) {
            return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
        }
    
        $ujians = Ujian::where('id_guru', $guru->id_guru)
            ->with(['kursus', 'guru'])
            ->orderBy('id_ujian', 'DESC')
            ->get();
    
        $courses = Kursus::all();
    
        return view('Role.Guru.Course.index', compact('user', 'ujians', 'courses'));
    }
    
    public function exportNilai($id_kursus)
    {
        $kursus = Kursus::findOrFail($id_kursus);
    
        // Membersihkan nama kursus dari karakter yang tidak diizinkan dalam nama file
        $fileName = $kursus->nama_kursus . '_nilai.xlsx';
    
        // Menghapus karakter "/" dan "\\" dari nama file
        $fileName = str_replace(['/', '\\'], '_', $fileName);
    
        return Excel::download(new NilaiExport($id_kursus), $fileName);
    }
     

    public function create(Request $request)
    {
        $guru = Guru::where('id_user', auth()->user()->id)->first();
    
        if (!$guru) {
            return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
        }
    
        $kursus = Kursus::where('id_guru', $guru->id_guru)->get(); 
    
        $tipeUjians = Tipe_Ujian::all();
        $user = auth()->user();
    
        return view('Role.Guru.Course.create', compact('kursus', 'tipeUjians', 'user'));
    }
    
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'id_kursus' => 'required|exists:kursus,id_kursus',
            'id_tipe_ujian' => 'required|in:1,2,3', // 1 = Kuis, 2 = Ujian Tengah Semester, 3 = Ujian Akhir Semester
            'acak' => 'nullable|in:Aktif,Tidak Aktif',
            'status_jawaban' => 'nullable|in:Aktif,Tidak Aktif',
            'grade' => 'nullable|numeric|min:0|max:100',
            'Waktu_Mulai' => 'required|date',
            'Waktu_Selesai' => 'required|date|after:Waktu_Mulai', // Waktu selesai harus setelah waktu mulai
        ]);
    
        try {
            // Mendapatkan data guru yang sedang login
            $guru = Guru::where('id_user', auth()->user()->id)->first();
    
            if (!$guru) {
                return redirect()->back()->withErrors(['error' => 'Guru tidak ditemukan.']);
            }
    
            // Menyimpan ujian ke dalam database
            $ujian = Ujian::create([
                'id_guru' => $guru->id_guru,
                'nama_ujian' => $validated['nama_ujian'],
                'password' => Hash::make($validated['password']), // Meng-hash password sebelum disimpan
                'id_kursus' => $validated['id_kursus'],
                'id_tipe_ujian' => $validated['id_tipe_ujian'],
                'acak' => $validated['acak'] ?? 'Tidak Aktif', // Default jika tidak diisi
                'status_jawaban' => $validated['status_jawaban'] ?? 'Tidak Aktif',
                'grade' => $validated['grade'] ?? 0,
                'tanggal_ujian' => $validated['Waktu_Mulai'],
                'Waktu_Selesai' => $validated['Waktu_Selesai'],
            ]);
    
            // Jika penyimpanan berhasil
            return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing ujian: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan ujian.']);
        }
    }
    
     
    public function show(Ujian $ujian)
    {
        $course = $ujian->kursus;
        return view('Role.Guru.Course.index', compact('ujian', 'course'));
    }

    public function edit($id_ujian)
    {
        try {
            $user = auth()->user();
            Log::info("User {$user->id} is editing Ujian with ID: {$id_ujian}");

            $ujian = Ujian::findOrFail($id_ujian);
            Log::info("Ujian found: {$ujian->nama_ujian}");

            return view('Role.Guru.Course.edit', compact('ujian', 'user'));
        } catch (\Exception $e) {
            Log::error("Error in edit Ujian with ID: {$id_ujian}. Error: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Ujian tidak ditemukan.']);
        }
    }

    public function update(Request $request, $id_ujian)
    {
        $ujian = Ujian::findOrFail($id_ujian);
    
        try {
            $validated = $request->validate([
                'nama_ujian' => 'nullable|string|max:255',
                'id_tipe_ujian' => 'nullable|in:1,2', // Kuis atau Ujian
                'acak' => 'nullable|in:Aktif,Tidak Aktif',
                'status_jawaban' => 'nullable|in:Aktif,Tidak Aktif',
                'grade' => 'nullable|numeric|min:0|max:100',
                'Waktu_Mulai' => 'nullable|date',
                'Waktu_Selesai' => 'nullable|date|after:Waktu_Mulai',
                'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            Log::info("Validation passed for Ujian ID: {$ujian->id_ujian}");
    
            if ($request->hasFile('Image')) {
                Log::info("Image file detected for Ujian ID: {$ujian->id_ujian}");
                if ($ujian->Image) {
                    Log::info("Deleting old image: {$ujian->Image}");
                    Storage::disk('public')->delete($ujian->Image);
                }
                $validated['Image'] = $request->file('Image')->store('images/ujians', 'public');
                Log::info("New image stored: {$validated['Image']}");
            }
    
            $ujian->update([
                'nama_ujian' => $validated['nama_ujian'],
                'id_tipe_ujian' => $validated['id_tipe_ujian'],
                'acak' => $validated['acak'],
                'status_jawaban' => $validated['status_jawaban'],
                'grade' => $validated['grade'],
                'tanggal_ujian' => $validated['Waktu_Mulai'],
                'Waktu_Selesai' => $validated['Waktu_Selesai'],
                'Image' => $validated['Image'] ?? $ujian->Image,
            ]);
    
            Log::info("Ujian ID: {$ujian->id_ujian} updated successfully.");
    
            return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating Ujian with ID: {$id_ujian}. Error: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui ujian.']);
        }
    }
    
    public function destroy(String $id_ujian)
    {
        try {
            // Cari ujian berdasarkan id_ujian
            $ujian = Ujian::findOrFail($id_ujian);
    
            // Hapus file gambar jika ada
            if ($ujian->Image) {
                Storage::disk('public')->delete($ujian->Image);
            }
    
            // Hapus ujian dari database
            $ujian->delete();
    
            // Redirect ke halaman daftar ujian dengan pesan sukses
            return redirect()->route('Guru.Ujian.index')->with('success', 'Ujian berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembali dengan pesan error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus ujian.']);
        }
    }
    public function prosesNilai($id_ujian)
    {
        try {
            // Ambil data ujian
            $ujian = Ujian::findOrFail($id_ujian);
            $kursus = $ujian->kursus;  // Dapatkan kursus dari ujian yang sedang berlangsung
            $siswa = Siswa::all();  // Ambil semua siswa yang mengikuti ujian

            // Ambil persentase nilai berdasarkan kursus
            $persentase = Persentase::where('id_kursus', $kursus->id_kursus)->first();

            // Jika persentase tidak ditemukan, tampilkan error
            if (!$persentase) {
                return redirect()->back()->withErrors(['error' => 'Persentase nilai untuk kursus ini tidak ditemukan.']);
            }

            // Loop untuk setiap siswa dan hitung nilai
            foreach ($siswa as $s) {
                // Mengambil nilai ujian untuk siswa (anda bisa ganti dengan data nilai yang sebenarnya)
                $nilai_ujian = $this->ambilNilaiUjian($ujian->id_ujian, $s->id_siswa); 

                // Menghitung nilai total berdasarkan persentase
                $nilaiTotal = ($nilai_ujian['nilai_kuis'] * $persentase->persentase_kuis / 100) +
                              ($nilai_ujian['nilai_ujian'] * $persentase->persentase_UTS / 100) +
                              ($nilai_ujian['nilai_uas'] * $persentase->persentase_UAS / 100);

                // Menyimpan nilai ke tabel nilai
                Nilai::create([
                    'id_kursus' => $kursus->id_kursus,
                    'id_siswa' => $s->id_siswa,
                    'nilai_kuis' => $nilai_ujian['nilai_kuis'],
                    'nilai_ujian' => $nilai_ujian['nilai_ujian'],
                    'nilai_uas' => $nilai_ujian['nilai_uas'],
                    'persentase_kuis' => $persentase->persentase_kuis,
                    'persentase_UTS' => $persentase->persentase_UTS,
                    'persentase_UAS' => $persentase->persentase_UAS,
                    'nilai_total' => $nilaiTotal,
                ]);
            }

            // Kembali ke halaman ujian dengan pesan sukses
            return redirect()->route('Guru.Ujian.index')->with('success', 'Nilai berhasil diproses.');

        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            Log::error('Error processing nilai: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memproses nilai.']);
        }
    }

    // Fungsi untuk mengambil nilai ujian, sesuaikan dengan cara pengambilan nilai yang sesungguhnya
    private function ambilNilaiUjian($id_ujian, $id_siswa)
    {
        // Untuk sekarang kita gunakan nilai acak, Anda bisa mengganti ini dengan logika untuk mendapatkan nilai ujian siswa
        return [
            'nilai_kuis' => rand(0, 100),  // Nilai acak untuk kuis
            'nilai_ujian' => rand(0, 100),  // Nilai acak untuk ujian
            'nilai_uas' => rand(0, 100),    // Nilai acak untuk UAS
        ];
    }
    
}
