<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_kursus',
        'id_siswa',
        'nilai_kuis',
        'nilai_UTS',
        'nilai_UAS',
        'nilai_total',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function hitungNilaiTotal()
    {
        // Ambil persentase yang sesuai berdasarkan kursus dan tipe ujian
        $persentase = $this->kursus->persentase()->where('id_kursus', $this->id_kursus)->first();

        // Hitung nilai total berdasarkan persentase
        $nilaiTotal = ($this->nilai_kuis * $persentase->persentase_kuis / 100) +
                      ($this->nilai_UTS * $persentase->persentase_UTS / 100) +
                      ($this->nilai_UAS * $persentase->persentase_UAS / 100);

        $this->nilai_total = $nilaiTotal;
        $this->save();
    }
}
