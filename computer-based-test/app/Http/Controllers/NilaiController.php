<?php
namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kursus;
use App\Models\Siswa;
use App\Models\TipeNilai;
use App\Models\NilaiKursus;
use App\Models\Persentase;
use App\Models\Tipe_Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function calculateAllNilai($id_kursus)
    {
        // Cek apakah persentase sudah diatur
        $persentaseCheck = Persentase::where('id_kursus', $id_kursus)->get();
        if ($persentaseCheck->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Persentase belum diatur. Silahkan atur persentase terlebih dahulu.'
            ], 422);
        }
        
        // Mulai transaksi database untuk memastikan integritas data
        DB::beginTransaction();
        
        try {
            // Ambil semua siswa dalam kursus
            $siswaList = Siswa::whereHas('kursus', function($query) use ($id_kursus) {
                $query->where('id_kursus', $id_kursus);
            })->get();
            
            $results = [];
            
            // Proses untuk setiap siswa
            foreach ($siswaList as $siswa) {
                $id_siswa = $siswa->id_siswa;
                
                // Ambil semua tipe ujian yang ada nilainya untuk siswa ini
                $tipeUjianList = TipeNilai::where('id_siswa', $id_siswa)
                    ->select('id_tipe_ujian')
                    ->distinct()
                    ->get()
                    ->pluck('id_tipe_ujian');
                
                $nilai_per_tipe = [];
                
                // 1. Hitung nilai per tipe ujian
                foreach ($tipeUjianList as $id_tipe_ujian) {
                    $nilai_tipe = $this->calculateNilaiKursus($id_kursus, $id_siswa, $id_tipe_ujian);
                    $nilai_per_tipe[$id_tipe_ujian] = $nilai_tipe;
                }
                
                // 2. Hitung nilai total
                $nilai_total = $this->calculateNilaiTotal($id_kursus, $id_siswa);
                
                $results[$id_siswa] = [
                    'nilai_total' => $nilai_total
                ];
            }
            
            // Commit transaksi jika semua berhasil
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Perhitungan nilai berhasil dilakukan untuk semua siswa',
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            
            Log::error('Error saat menghitung nilai: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghitung nilai: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghitung nilai per tipe ujian
     */
    private function calculateNilaiKursus($id_kursus, $id_siswa, $id_tipe_ujian)
    {
        // Ambil semua nilai untuk tipe ujian ini
        $nilaiList = TipeNilai::where('id_siswa', $id_siswa)
            ->where('id_tipe_ujian', $id_tipe_ujian)
            ->get();
        
        // Hitung rata-rata nilai
        $totalNilai = 0;
        $count = $nilaiList->count();
        
        if ($count > 0) {
            $totalNilai = $nilaiList->sum('nilai') / $count;
        }
        
        // Simpan atau update nilai kursus
        NilaiKursus::updateOrCreate(
            [
                'id_kursus' => $id_kursus,
                'id_siswa' => $id_siswa,
                'id_tipe_ujian' => $id_tipe_ujian,
            ],
            [
                'nilai_tipe_ujian' => $totalNilai,
            ]
        );
        
        return $totalNilai;
    }

    /**
     * Menghitung nilai total dengan persentase
     */
    private function calculateNilaiTotal($id_kursus, $id_siswa)
    {
        // Ambil semua nilai kursus untuk siswa ini
        $nilaiKursusList = NilaiKursus::where('id_kursus', $id_kursus)
            ->where('id_siswa', $id_siswa)
            ->get();
        
        $nilaiTotal = 0;
        
        // Hitung nilai total berdasarkan persentase
        foreach ($nilaiKursusList as $nilaiKursus) {
            // Ambil persentase untuk tipe ujian ini
            $persentase = Persentase::where('id_kursus', $id_kursus)
                ->where('id_tipe_ujian', $nilaiKursus->id_tipe_ujian)
                ->first();
            
            if ($persentase) {
                // Hitung nilai berdasarkan persentase
                $nilaiTotal += ($nilaiKursus->nilai_tipe_ujian * $persentase->persentase / 100);
            }
        }
        
        // Simpan atau update nilai total
        Nilai::updateOrCreate(
            [
                'id_kursus' => $id_kursus,
                'id_siswa' => $id_siswa,
            ],
            [
                'nilai_total' => $nilaiTotal,
            ]
        );
        
        return $nilaiTotal;
    }
}
