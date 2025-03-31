package models

import "time"

type Bisnis struct {
    ID               uint      `gorm:"primaryKey" json:"id"`
    Nama             string    `json:"nama"`
    Username         string    `json:"username"`
    JumlahPendapatan float64   `json:"jumlah_pendapatan"`
    CreatedAt        time.Time `json:"created_at"`
    UpdatedAt        time.Time `json:"updated_at"`
}