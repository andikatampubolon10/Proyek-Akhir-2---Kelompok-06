package entity

import "time"

type Materi struct {
    IdMateri      uint64    `gorm:"primary_key;autoIncrement" json:"id_materi"`
    JudulMateri   string    `gorm:"type:varchar(255);not null" json:"judul_materi"`
    Deskripsi     string    `gorm:"type:varchar(255);not null" json:"deskripsi"`
    File          string    `gorm:"type:varchar(255);not null" json:"file"` // Menyimpan path file
    FileUrl       string    `gorm:"type:varchar(255);not null" json:"file_url"` // Menyimpan URL file
    IdKursus      uint64    `gorm:"type:bigint(20) unsigned" json:"id_kursus"`
    CreatedAt     time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP" json:"created_at"`
    UpdatedAt     time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" json:"updated_at"`

    Kursus        Kursus   `gorm:"foreignkey:IdKursus;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"kursus"`
}
