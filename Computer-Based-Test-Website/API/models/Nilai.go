package models

import "time"

type Nilai struct {
    ID          uint      `gorm:"primaryKey" json:"id"`
    UserID      uint      `json:"user_id"`
    QuizID      *uint     `json:"quiz_id"`
    UjianID     *uint     `json:"ujian_id"`
    Persentase  float64   `json:"persentase"`
    NilaiAkhir  float64   `json:"nilai_akhir"`
    CreatedAt   time.Time `json:"created_at"`
    UpdatedAt   time.Time `json:"updated_at"`
}