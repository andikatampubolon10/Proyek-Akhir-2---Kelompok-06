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
        'id_nilai',
        'id_kursus',
        'id_siswa',
        'nilai_kuis',
        'nilai_ujian',
        'nilai_total',
    ];

    protected $guarded = ['id_nilai'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
    
}