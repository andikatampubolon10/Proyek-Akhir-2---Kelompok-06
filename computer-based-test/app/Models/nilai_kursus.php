<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKursus extends Model
{
    protected $table = 'nilai_kursus';

    protected $fillable = [
        'nilai_tipe_ujian',
        'id_kursus',
        'id_siswa',
        'id_tipe_ujian',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus','id_kursus');
    }    

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function tipeUjian()
    {
        return $this->belongsTo(tipe_ujian::class, 'id_tipe_ujian');
    }

}
