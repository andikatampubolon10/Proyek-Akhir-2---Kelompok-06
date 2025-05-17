<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{

    protected $table = 'kelas'; 

    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'id_kelas',
        'nama_kelas',
        'id_operator',
    ];

    public function operator(){
        return $this->belongsTo(operator::class);
    }

    public function siswa(){
        return $this->hasMany(siswa::class,'id_kelas','id_kelas');
    }
}
