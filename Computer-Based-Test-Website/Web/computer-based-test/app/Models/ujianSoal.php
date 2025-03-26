<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ujianSoal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];
    
    public function Ujian(){
        return $this->belongsTo(Ujian::class);
    }

    public function answer(){
        return $this->hasMany(jawabanSiswaUjian::class, 'jawabanSiswaUjian_id', 'id');
    }
}
