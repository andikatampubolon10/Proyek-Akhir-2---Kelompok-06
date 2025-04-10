<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipe_soal extends Model
{

    protected $table = 'tipe_soal'; 

    protected $primaryKey = 'id_tipe_soal';

    protected $fillable = [
        'id_tipe_soal',
        'nama_tipe_soal',
        'id_soal',
    ];

    public function soal(){
        return $this->belongsTo(soal::class);
    }

    public function jawaban_soal(){
        return $this->hasOne(jawaban_soal::class);
    }
}
