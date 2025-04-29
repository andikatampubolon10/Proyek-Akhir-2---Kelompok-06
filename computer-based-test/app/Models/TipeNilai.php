<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeNilai extends Model
{
    use HasFactory;

    protected $table = 'tipe_nilai';

    protected $primaryKey = 'id_tipe_nilai';

    protected $fillable = [
        'nilai_kuis',
        'nilai_UTS',
        'nilai_UAS',
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_tipe_nilai');
    }

    public function kursus()
{
    return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus');
}

}
