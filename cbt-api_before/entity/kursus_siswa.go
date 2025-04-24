package entity

import "time"

type KursusSiswa struct {
    IdKursusSiswa  uint64    `gorm:"primary_key;autoIncrement" json:"id_kursus_siswa"`
    IdSiswa        uint64    `gorm:"type:bigint(20) unsigned" json:"id_siswa"`
    IdKursus       uint64    `gorm:"type:bigint(20) unsigned" json:"id_kursus"`
    CreatedAt      time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP" json:"created_at"`
    UpdatedAt      time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" json:"updated_at"`

    Kursus   Kursus   `gorm:"foreignkey:id_kursus;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"kursus"`
    Siswa    Siswa    `gorm:"foreignkey:id_siswa;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"siswa"`
}
