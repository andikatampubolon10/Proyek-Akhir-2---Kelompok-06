<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function Quiz(){
        return $this->hasMany(Quiz::class, 'Quiz_id', 'id');
    }

    public function Ujian(){
        return $this->hasMany(Ujian::class, 'Ujian_id', 'id');
    }

    
    public function Siswa(){
        return $this->hasMany(User::class, 'course_id', 'user_id');
    }
}
