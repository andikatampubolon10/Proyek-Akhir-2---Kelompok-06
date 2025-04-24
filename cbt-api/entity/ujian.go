package entity

import "time"

type Ujian struct {
    IdUjian        uint64    `gorm:"primary_key;autoIncrement" json:"id_ujian"`
    NamaUjian      string    `gorm:"type:varchar(255);not null" json:"nama_ujian"`
    Acak           string    `gorm:"type:enum('Aktif', 'Tidak Aktif');not null" json:"acak"`
    StatusJawaban  string    `gorm:"type:enum('Aktif', 'Tidak Aktif');not null" json:"status_jawaban"`
    Grade          float64   `gorm:"type:double" json:"grade"`
    IdKursus       uint64    `gorm:"type:bigint(20) unsigned" json:"id_kursus"`
    Password       string    `gorm:"type:varchar(255);not null" json:"-"` 
    // IdGuru         uint64    `gorm:"type:bigint(20) unsigned" json:"id_guru"`
    IdTipeUjian    uint64    `gorm:"type:bigint(20) unsigned" json:"id_tipe_ujian"`
    CreatedAt      time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP" json:"created_at"`
    UpdatedAt      time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" json:"updated_at"`

    Kursus   Kursus     `gorm:"foreignkey:IdKursus;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"kursus"`
    // Guru     Guru       `gorm:"foreignkey:IdGuru;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"guru"`
    TipeUjian TipeUjian `gorm:"foreignkey:IdTipeUjian;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"tipe_ujian"`
}
