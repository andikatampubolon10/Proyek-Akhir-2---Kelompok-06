<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = 'weeks';
    protected $primaryKey = 'id_week';
    protected $fillable = [
        'id_week',
        'week',
    ];

    public function ujian() {
        return $this->hasMany(Ujian::class, 'id_ujian');  // Relasi kursus ke minggu
    }
}
