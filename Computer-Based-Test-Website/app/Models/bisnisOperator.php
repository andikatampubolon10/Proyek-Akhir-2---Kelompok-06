<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class bisnisOperator extends Model
{
    use HasFactory;

    protected $table = 'bisnis_operator';

    protected $fillable = ['name', 'revenue'];
}
