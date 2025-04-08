package models

import "time"

type JawabanSiswaLatihanSoal struct {
    ID               uint      `gorm:"primaryKey" json:"id"`
    JawabanSiswa     string    `json:"jawaban_siswa"`
    Correct          bool      `json:"correct"`
    LatihanSoalID    uint      `json:"latihan_soal_id"`
    LatihanSoalSoalID uint     `json:"latihan_soal_soal_id"`
    UserID           uint      `json:"user_id"`
    CreatedAt        time.Time `json:"created_at"`
    UpdatedAt        time.Time `json:"updated_at"`
}