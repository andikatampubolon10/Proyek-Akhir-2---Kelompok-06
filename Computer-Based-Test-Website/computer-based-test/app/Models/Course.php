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

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id', 'id');
    }

    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'course_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(User::class, 'course_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}