package entity

import "time"

type Soal struct {
    IdSoal    uint64    `gorm:"primary_key;autoIncrement" json:"id_soal"`
    Soal      string    `gorm:"type:varchar(255);not null" json:"soal"`
    IdUjian   uint64    `gorm:"type:bigint(20) unsigned" json:"id_ujian"`
    IdLatihan uint64    `gorm:"type:bigint(20) unsigned" json:"id_latihan"`
    CreatedAt        time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP" json:"created_at"`
    UpdatedAt        time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" json:"updated_at"`

    Ujian   Ujian   `gorm:"foreignkey:IdUjian;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"ujian"`
    Latihan Latihan `gorm:"foreignkey:IdLatihan;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"latihan"`
}
