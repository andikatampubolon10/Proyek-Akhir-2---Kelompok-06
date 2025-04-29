<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Materi extends Model
    {
        use HasFactory;

        protected $table = 'materi';

        protected $fillable = [
            'judul_materi',
            'deskripsi',
            'week',
            'file',
            'id_kursus',
            'id_guru',
        ];

        public function kursus()
        {
            return $this->belongsTo(Kursus::class, 'id_kursus');
        }

        public function guru()
        {
            return $this->belongsTo(Guru::class, 'id_guru');
        }
    }
