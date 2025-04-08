package models

import "time"

type Operator struct {
    ID           uint      `gorm:"primaryKey" json:"id"`
    NamaSekolah  string    `json:"nama_sekolah"`
    Email        string    `json:"email"`
    Password     string    `json:"password"`
    StatusAktif  bool      `json:"status_aktif"`
    Durasi       int       `json:"durasi"`
    CreatedAt    time.Time `json:"created_at"`
    UpdatedAt    time.Time `json:"updated_at"`
}