<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    protected $table = 'kursus';

    protected $primaryKey = 'id_kursus';

    protected $fillable = [
        'id_kursus',
        'nama_kursus',
        'password',
        'id_guru',
        'image',
        'persentase_kuis',
        'persentase_ujian',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function kursus_siswa()
    {
        return $this->hasMany(KursusSiswa::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class, 'id_kursus', 'id_kursus', 'id_kursus');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_kursus', 'id_kursus');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_materi', 'id_materi');
    }
}