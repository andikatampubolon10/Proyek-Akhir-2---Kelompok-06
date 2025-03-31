package models

import "time"

type Course struct {
    ID          uint      `gorm:"primaryKey" json:"id"`
    NamaCourse  string    `json:"nama_course"`
    Password    string    `json:"password"`
    UserID      uint      `json:"user_id"`
    DeletedAt   *time.Time `json:"deleted_at"`
    CreatedAt   time.Time `json:"created_at"`
    UpdatedAt   time.Time `json:"updated_at"`
}
