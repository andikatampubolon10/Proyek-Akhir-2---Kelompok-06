<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mata_pelajaran_siswa extends Model
{

    protected $table = 'mata_pelajaran_siswa'; 

    protected $primaryKey = 'id_mata_pelajaran_siswa';

    protected $fillable = [
        'id_mata_pelajaran_siswa',
        'id_siswa',
        'id_mata_pelajaran',
    ];

    public function siswa(){
        return $this->belongsTo(siswa::class);
    }

    public function mata_pelajaran(){
        return $this->belongsTo(mata_pelajaran::class);
    }
}
