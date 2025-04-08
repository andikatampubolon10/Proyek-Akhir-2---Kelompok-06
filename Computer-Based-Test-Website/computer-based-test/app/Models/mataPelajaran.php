<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}