<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_sekolah',
        'email',
        'password',
        'status_aktif',
        'durasi',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static $rules = [
        'status_aktif' => 'in:aktif,tidak aktif',
    ];
}