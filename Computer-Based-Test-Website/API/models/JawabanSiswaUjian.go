package models

import "time"

type JawabanSiswaUjian struct {
    ID         uint      `gorm:"primaryKey" json:"id"`
    JawabanSiswa string  `json:"jawaban_siswa"`
    Correct    bool      `json:"correct"`
    UjianID    uint      `json:"ujian_id"`
    UjianSoalID uint     `json:"ujian_soal_id"`
    UserID     uint      `json:"user_id"`
    CreatedAt  time.Time `json:"created_at"`
    UpdatedAt  time.Time `json:"updated_at"`
}