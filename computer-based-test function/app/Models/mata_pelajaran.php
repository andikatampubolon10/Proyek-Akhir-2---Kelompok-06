<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mata_pelajaran extends Model
{

    protected $table = 'mata_pelajaran'; 

    protected $primaryKey = 'id_mata_pelajaran';  

    protected $fillable = [
        'id_mata_pelajaran',
        'nama_mata_pelajaran',
        'id_operator',
        'id_kurikulum',
    ];

    public function operator(){
        return $this->belongsTo(operator::class);
    }

    public function kurikulum(){
        return $this->belongsTo(kurikulum::class);
    }

    public function mata_pelajaran_siswa(){
        return $this->hasMany(mata_pelajaran_siswa::class);
    }

    public function guru(){
        return $this->hasOne(guru::class);
    }
}
