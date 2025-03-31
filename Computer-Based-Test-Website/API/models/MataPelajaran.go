package models

import "time"

type MataPelajaran struct {
    ID              uint      `gorm:"primaryKey" json:"id"`
    NamaMataPelajaran string  `json:"nama_mata_pelajaran"`
    KurikulumID     uint      `json:"kurikulum_id"`
    UserID          uint      `json:"user_id"`
    DeletedAt       *time.Time `json:"deleted_at"`
    CreatedAt       time.Time `json:"created_at"`
    UpdatedAt       time.Time `json:"updated_at"`
}