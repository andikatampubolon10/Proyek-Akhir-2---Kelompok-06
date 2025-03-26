<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class latihanSoalSoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function answer(){
        return $this->hasMany(jawabanSiswaLatihanSoal::class, 'jawabanSiswaLatihanSoal_id', 'id');
    }
}
