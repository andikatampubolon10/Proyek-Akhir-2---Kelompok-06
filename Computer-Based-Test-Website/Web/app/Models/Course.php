<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];
}
