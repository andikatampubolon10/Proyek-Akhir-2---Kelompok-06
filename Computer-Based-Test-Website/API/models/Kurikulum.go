package models

import "time"

type Kurikulum struct {
    ID           uint      `gorm:"primaryKey" json:"id"`
    NamaKurikulum string   `json:"nama_kurikulum"`
    UserID       uint      `json:"user_id"`
    DeletedAt    *time.Time `json:"deleted_at"`
    CreatedAt    time.Time `json:"created_at"`
    UpdatedAt    time.Time `json:"updated_at"`
}