<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bisnis extends Model
{
    //
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nama',
        'username',
        'jumlah_pendapatan'
    ];
}
