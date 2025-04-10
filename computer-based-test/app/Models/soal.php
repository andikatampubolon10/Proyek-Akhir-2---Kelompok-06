<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class soal extends Model
{
    
    protected $table = 'soal'; 

    protected $primaryKey = 'id_soal';

    protected $fillable = [
        'id_soal',
        'soal',
        'id_ujian',
        'id_latihan',
    ];

    public function ujian(){
        return $this->belongsTo(ujian::class);
    }

    public function latihan(){
        return $this->belongsTo(latihan::class);
    }

    public function jawaban_soal(){
        return $this->hasMany(jawaban_soal::class);
    }

    public function jawaban_siswa(){
        return $this->hasMany(jawaban_siswa::class);
    }

    public function tipe_soal(){
        return $this->hasMany(tipe_soal::class);
    }
}
