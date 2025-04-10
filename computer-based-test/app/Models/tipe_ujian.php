<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipe_ujian extends Model
{

    protected $table = 'tipe_ujian'; 

    protected $primaryKey = 'id_tipe_ujian';

    protected $fillable = [
        'id_tipe_ujian',
        'nama_tipe_ujian',
    ];

    public function ujian(){
        return $this->hasMany(ujian::class);
    }
}
