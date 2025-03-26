<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mataPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function Kurikulum(){
        return $this->belongsTo(Kurikulum::class);
    }

    public function MataPelajaran(){
        return $this->belongsTo(Operator::class);
    }
}
