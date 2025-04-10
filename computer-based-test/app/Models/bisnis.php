<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bisnis extends Model
{
    protected $fillable = [
        'id_bisnis',
        'nama_sekolah',
        'jumlah_pendapatan',
    ];
}
