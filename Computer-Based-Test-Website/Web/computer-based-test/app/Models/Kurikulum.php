<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurikulum extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function Mapel(){
        return $this->hasMany(mataPelajaran::class, 'mataPelajaran_id', 'id');
    }

    public function Kurikulum(){
        return $this->belongsTo(Operator::class);
    }
}
