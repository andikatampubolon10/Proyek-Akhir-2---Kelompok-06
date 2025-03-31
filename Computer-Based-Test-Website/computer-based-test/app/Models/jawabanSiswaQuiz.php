<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jawabanSiswaQuiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];
    
    public function jawabanQuiz(){
        return $this->belongsTo(quizSoal::class);
    }
}
