package models

import "time"

type LatihanSoal struct {
    ID              uint      `gorm:"primaryKey" json:"id"`
    Nilai           int       `json:"nilai"`
    Image           string    `json:"image"`
    CourseID        uint      `json:"course_id"`
    KurikulumID     uint      `json:"kurikulum_id"`
    KelasID         uint      `json:"kelas_id"`
    MataPelajaranID uint      `json:"mata_pelajaran_id"`
    UserID          uint      `json:"user_id"`
    DeletedAt       *time.Time `json:"deleted_at"`
    CreatedAt       time.Time `json:"created_at"`
    UpdatedAt       time.Time `json:"updated_at"`
}