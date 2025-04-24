package entity

import "time"

type Latihan struct {
    IdLatihan     uint64    `gorm:"primary_key;autoIncrement" json:"id_latihan"`
    SoalLatihan   string    `gorm:"type:varchar(255);not null" json:"soal_latihan"`
    Acak          string    `gorm:"type:enum('Aktif', 'Tidak Aktif');not null" json:"acak"`
    StatusJawaban string    `gorm:"type:enum('Aktif', 'Tidak Aktif');not null" json:"status_jawaban"`
    Grade         float64   `gorm:"type:double" json:"grade"`
    IdGuru        uint64    `gorm:"type:bigint(20) unsigned" json:"id_guru"`
    CreatedAt        time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP" json:"created_at"`
    UpdatedAt        time.Time `gorm:"type:timestamp;default:CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP" json:"updated_at"`

    Guru    Guru    `gorm:"foreignkey:IdGuru;constraint:onUpdate:CASCADE, onDelete:CASCADE" json:"guru"`
}
