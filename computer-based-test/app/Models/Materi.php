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
            'file_url',
            'id_kursus',
            'id_guru',
        ];

        protected $appends = ['file_url']; 

        public function getFileUrlAttribute()
        {
            return asset('storage/' . $this->file);
        }

        public function kursus()
        {
            return $this->belongsTo(Kursus::class, 'id_kursus');
        }

        public function guru()
        {
            return $this->belongsTo(Guru::class, 'id_guru');
        }
    }
