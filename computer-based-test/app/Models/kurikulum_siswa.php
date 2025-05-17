<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kurikulum_siswa extends Model
{

    protected $table = 'kurikulum_siswa'; 

    protected $primaryKey = 'id_kurikulum_siswa';

    protected $fillable = [
        'id_kurikulum_siswa',
        'id_kurikulum',
        'id_siswa',
    ];

    public function kurikulum(){
        return $this->belongsTo(kurikulum::class);
    }

    public function siswa(){
        return $this->belongsTo(siswa::class);
    }
}
