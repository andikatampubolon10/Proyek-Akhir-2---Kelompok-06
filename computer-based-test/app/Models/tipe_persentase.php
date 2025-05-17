<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipe_persentase extends Model
{
    protected $table = 'tipe_persentase';

    protected $primaryKey = 'id_tipe_persentase';

    protected $fillable = [
        'nama_persentase', 
    ];

    public function persentase()
    {
        return $this->hasMany(Persentase::class, 'id_tipe_persentase', 'id_tipe_persentase', 'id_tipe_persentase','id_tipe_persentase');
    }
}
