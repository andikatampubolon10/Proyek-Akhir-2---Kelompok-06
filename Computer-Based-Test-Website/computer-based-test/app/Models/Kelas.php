<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function Kelas(){
        return $this->belongsTo(Operator::class);
    }

}
