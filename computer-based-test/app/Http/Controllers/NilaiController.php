<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kursus;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $courses = kursus::with('guru')->get();
        $user = auth()->user();
        return view('Role.Guru.Nilai.index', compact('courses', 'user'));
    }

    // Menampilkan form untuk membuat nilai baru
    public function create()
    {
        $user = auth()->user();
        return view('Role.Guru.Nilai.create', compact('user'));
    }

    public function prosesNilai($id_ujian)
    {
        try {
            // Ambil data ujian
            $ujian = Ujian::findOrFail($id_ujian);
            $kursus = $ujian->kursus;
            $siswa = Siswa::all();
    
            // Ambil persentase berdasarkan kursus
            $persentase = Persentase::where('id_kursus', $kursus->id_kursus)->get();
    
            // Loop untuk setiap siswa dan hitung nilai
            foreach ($siswa as $s) {
                // Ambil nilai kuis, UTS, dan UAS
                $nilai_kuis = rand(0, 100);
                $nilai_uts = rand(0, 100);
                $nilai_uas = rand(0, 100);
    
                // Masukkan nilai ke tipe_nilai
                $tipeNilai = TipeNilai::create([
                    'nilai_kuis' => $nilai_kuis,
                    'nilai_UTS' => $nilai_uts,
                    'nilai_UAS' => $nilai_uas
                ]);
    
                // Menghitung nilai total
                $nilaiTotal = ($nilai_kuis * $persentase->where('id_tipe_ujian', 1)->first()->persentase / 100) +
                              ($nilai_uts * $persentase->where('id_tipe_ujian', 2)->first()->persentase / 100) +
                              ($nilai_uas * $persentase->where('id_tipe_ujian', 3)->first()->persentase / 100);
    
                // Masukkan data nilai ke tabel nilai
                Nilai::create([
                    'id_kursus' => $kursus->id_kursus,
                    'id_siswa' => $s->id_siswa,
                    'id_persentase' => $persentase->first()->id_persentase,
                    'id_tipe_nilai' => $tipeNilai->id_tipe_nilai,
                    'nilai_total' => $nilaiTotal,
                ]);
            }
    
            return redirect()->route('Guru.Ujian.index')->with('success', 'Nilai berhasil diproses.');
        } catch (\Exception $e) {
            Log::error('Error processing nilai: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memproses nilai.']);
        }
    }

    public function hitungNilaiTotal()
    {
        // Ambil semua nilai untuk kuis, UTS, dan UAS terkait dengan kursus ini
        $tipeNilai = $this->kursus->tipeNilai()->where('id_kursus', $this->id_kursus)->get();
    
        $totalKuis = 0;
        $totalUTS = 0;
        $totalUAS = 0;
    
        // Looping untuk setiap nilai ujian
        foreach ($tipeNilai as $nilai) {
            $totalKuis += $nilai->nilai_kuis;
            $totalUTS += $nilai->nilai_UTS;
            $totalUAS += $nilai->nilai_UAS;
        }
    
        // Ambil persentase berdasarkan id_kursus dan id_tipe_ujian
        $persentase = Persentase::where('id_kursus', $this->id_kursus)
                                ->get()
                                ->keyBy('id_tipe_ujian');  // Menyusun berdasarkan id_tipe_ujian
    
        // Hitung nilai total berdasarkan persentase
        $nilaiTotal = ($totalKuis * $persentase[1]->persentase / 100) +  // Kuis
                      ($totalUTS * $persentase[2]->persentase / 100) +   // UTS
                      ($totalUAS * $persentase[3]->persentase / 100);   // UAS
    
        $this->nilai_total = $nilaiTotal;
        $this->save();
    }    
        
    // Fungsi untuk mengambil nilai ujian, sesuaikan dengan cara pengambilan nilai yang sesungguhnya
    private function ambilNilaiUjian($id_ujian, $id_siswa)
    {
        // Untuk sekarang kita gunakan nilai acak, Anda bisa mengganti ini dengan logika untuk mendapatkan nilai ujian siswa
        return [
            'nilai_kuis' => rand(0, 100),  // Nilai acak untuk kuis
            'nilai_uts' => rand(0, 100),   // Nilai acak untuk ujian tengah semester
            'nilai_uas' => rand(0, 100),   // Nilai acak untuk ujian akhir semester
        ];
    }
    
}