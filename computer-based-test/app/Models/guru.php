<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guru extends Model
{

    protected $table = 'guru'; 

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'id_guru',
        'nama_guru',
        'nip',
        'status',
        'id_user',
        'id_operator',
    ];

    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function operator() {
        return $this->belongsTo(operator::class);
    }

    public function kursus(){
        return $this->hasMany(kursus::class);
    }

    public function guru(){
        return $this->hasMany(latihan::class);
    }

    public function ujian(){
        return $this->hasMany(ujian::class);
    }
}
