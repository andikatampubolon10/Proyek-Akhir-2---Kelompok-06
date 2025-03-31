<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LatihanSoalSoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function latihanSoal()
    {
        return $this->belongsTo(LatihanSoal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaLatihanSoal::class, 'latihan_soal_soal_id', 'id');
    }
}