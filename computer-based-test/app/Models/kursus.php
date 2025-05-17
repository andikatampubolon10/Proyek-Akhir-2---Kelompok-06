<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    protected $table = 'kursus';

    protected $primaryKey = 'id_kursus';

    protected $appends = ['foto_url'];

    protected $fillable = [
        'id_kursus',
        'nama_kursus',
        'password',
        'id_guru',
        'image',
        'image_url',
    ];

    protected function getFotoUrlAttribute($value)
    {
        $defaultFoto = \DB::table('settings')->where('key', 'default_student_photo')->value('value');

        if (!$defaultFoto) {
            $defaultFoto = 'images/student-default.png';  // Default fallback jika tidak ada di database
        }

        if ($this->attributes['image'] == null || $this->attributes['image'] == '') {
            return asset($defaultFoto);
        }

        $foto = (Storage::exists($this->attributes['image'])) ? $this->attributes['image'] : $defaultFoto;

        return url(Storage::url($foto));
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function kursusSiswa()
    {
        return $this->hasMany(KursusSiswa::class);
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class, 'id_kursus', 'id_kursus');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_kursus', 'id_kursus');
    }

    public function persentase()
    {
        return $this->hasMany(Persentase::class, 'id_kursus', 'id_kursus','id_kursus');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_materi', 'id_materi');
    }

    public function tipeNilai()
    {
        return $this->hasMany(TipeNilai::class, 'id_kursus', 'id_kursus');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kursus_siswa', 'id_kursus', 'id_siswa');
    }
}
