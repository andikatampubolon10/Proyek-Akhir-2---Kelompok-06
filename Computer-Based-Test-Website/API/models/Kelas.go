package models

import "time"

type Kelas struct {
    ID         uint      `gorm:"primaryKey" json:"id"`
    NamaKelas  string    `json:"nama_kelas"`
    UserID     uint      `json:"user_id"`
    CreatedAt  time.Time `json:"created_at"`
    UpdatedAt  time.Time `json:"updated_at"`
}