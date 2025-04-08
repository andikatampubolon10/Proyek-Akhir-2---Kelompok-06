<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'nis',
        'password', 
    ];
}
