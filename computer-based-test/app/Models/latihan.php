<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class latihan extends Model
{

    protected $table = 'latihan'; 

    protected $primaryKey = 'id_latihan';

    protected $fillable = [
        'id_latihan',
        'soal_latihan',
        'acak',
        'status_jawaban',
        'grade',
        'id_guru',
    ];

    public function guru(){
        return $this->belongsTo(guru::class);
    }

    public function soal(){
        return $this->hasMany(soal::class);
    }
}
