<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujian'; 

    protected $primaryKey = 'id_ujian';

    protected $fillable = [
        'id_ujian',
        'nama_ujian',
        'acak',
        'status_jawaban',
        'grade',
        'week',
        'password',
        'id_kursus',
        'id_guru',
        'id_tipe_ujian',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus','id_kursus');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function tipe_ujian()
    {
        return $this->belongsTo(tipe_ujian::class, 'id_tipe_ujian');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
}