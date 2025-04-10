<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kursus extends Model
{

    protected $table = 'kursus';

    protected $primaryKey = 'id_kursus';

    protected $fillable = [
        'id_kursus',
        'nama_kursus',
        'password',
        'id_guru',
        'image',
    ];

    public function guru()
    {
        return $this->belongsTo(guru::class, 'id_guru', 'id_guru');
    }

    public function kursus_siswa(){
        return $this->hasMany(kursus_siswa::class);
    }

    public function ujian(){
        return $this->hasMany(ujian::class);
    }
}
