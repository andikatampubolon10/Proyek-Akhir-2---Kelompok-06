<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_materi';

    protected $table = 'materi';

    protected $fillable = [
        'judul_materi',
        'deskripsi',
        'file',
        'file_url',
        'tanggal_materi',
        'id_kursus',
        'id_guru',
    ];

    // Relasi dengan model Kursus
    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus');
    }

    // Relasi dengan model Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
