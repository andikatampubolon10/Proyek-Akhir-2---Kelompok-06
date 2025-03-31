package models

import "time"

type Quiz struct {
    ID           uint      `gorm:"primaryKey" json:"id"`
    Password     string    `json:"password"`
    WaktuMulai   time.Time `json:"waktu_mulai"`
    WaktuSelesai time.Time `json:"waktu_selesai"`
    WaktuLihat   time.Time `json:"waktu_lihat"`
    CourseID     uint      `json:"course_id"`
    UserID       uint      `json:"user_id"`
    DeletedAt    *time.Time `json:"deleted_at"`
    CreatedAt    time.Time `json:"created_at"`
    UpdatedAt    time.Time `json:"updated_at"`
}