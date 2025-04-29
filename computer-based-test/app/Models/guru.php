<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'id_guru',
        'nama_guru',
        'nip',
        'status',
        'id_mata_pelajaran',
        'id_user',
        'id_operator',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function kursus()
    {
        return $this->hasMany(Kursus::class, 'id_guru', 'id_guru');
    }

    public function latihan()
    {
        return $this->hasMany(Latihan::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class, 'id_guru', 'id_guru');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_materi', 'id_materi');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_kursus', 'id_kursus');
    }
}