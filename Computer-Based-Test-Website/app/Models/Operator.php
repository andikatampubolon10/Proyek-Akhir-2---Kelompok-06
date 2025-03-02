<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = ['sekolah', 'username', 'password', 'duration', 'status', 'expiry_date'];

    protected $table = 'operators';
}
