<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TipeNilai;
use App\Models\Persentase;
use App\Models\NilaiKursus;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function hitungDanSimpanNilai($id_siswa, $id_tipe_ujian)
    {
        // Ambil nilai dari Tipe_Nilai berdasarkan id_siswa dan id_tipe_ujian
        $nilaiSiswa = TipeNilai::where('id_siswa', $id_siswa)
                                ->where('id_tipe_ujian', $id_tipe_ujian)
                                ->first();

        // Ambil persentase berdasarkan id_tipe_ujian dan id_kursus
        $persentase = Persentase::where('id_tipe_ujian', $id_tipe_ujian)
                                ->where('id_kursus', $nilaiSiswa->kursus->id_kursus) // Asumsikan relasi dengan kursus
                                ->first();

        // Akumulasi nilai dengan persentase
        $nilaiTotal = $nilaiSiswa->nilai * ($persentase->persentase / 100);

        // Simpan nilai yang telah dihitung ke Nilai_Kursus
        NilaiKursus::create([
            'id_kursus' => $nilaiSiswa->kursus->id_kursus,
            'id_siswa' => $id_siswa,
            'nilai_tipe_ujian' => $id_tipe_ujian,
            'nilai_total' => $nilaiTotal,
        ]);

        // Setelah itu, kita akan simpan nilai akhir ke tabel Nilai
        $this->simpanNilaiAkhir($id_siswa);
    }

    // Fungsi untuk menyimpan nilai akhir ke tabel Nilai
    public function simpanNilaiAkhir($id_siswa)
    {
        // Ambil nilai total dari Nilai_Kursus untuk siswa ini
        $nilaiKursus = NilaiKursus::where('id_siswa', $id_siswa)->first();

        // Simpan nilai akhir ke tabel Nilai
        Nilai::create([
            'id_siswa' => $id_siswa,
            'id_kursus' => $nilaiKursus->id_kursus,
            'id_tipe_nilai' => 1, // Anggap 1 untuk nilai ujian akhir, bisa disesuaikan
            'nilai_total' => $nilaiKursus->nilai_total,
        ]);
    }
}
