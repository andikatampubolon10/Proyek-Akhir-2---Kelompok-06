package models

import "time"

type JawabanSiswaQuiz struct {
    ID         uint      `gorm:"primaryKey" json:"id"`
    JawabanSiswa string  `json:"jawaban_siswa"`
    Correct    bool      `json:"correct"`
    QuizID     uint      `json:"quiz_id"`
    QuizSoalID uint      `json:"quiz_soal_id"`
    UserID     uint      `json:"user_id"`
    CreatedAt  time.Time `json:"created_at"`
    UpdatedAt  time.Time `json:"updated_at"`
}