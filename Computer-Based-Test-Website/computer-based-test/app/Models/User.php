<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the courses associated with the user.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }

    /**
     * Get the quizzes associated with the user.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'user_id', 'id');
    }

    /**
     * Get the ujians associated with the user.
     */
    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'user_id', 'id');
    }

    /**
     * Get the latihan soals associated with the user.
     */
    public function latihanSoals()
    {
        return $this->hasMany(LatihanSoal::class, 'user_id', 'id');
    }

    /**
     * Get the quiz soals associated with the user.
     */
    public function quizSoals()
    {
        return $this->hasMany(QuizSoal::class, 'user_id', 'id');
    }

    /**
     * Get the password reset tokens associated with the user.
     */
    public function passwordResetTokens()
    {
        return $this->hasOne(PasswordResetToken::class, 'email', 'email');
    }

    /**
     * Get the sessions associated with the user.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}