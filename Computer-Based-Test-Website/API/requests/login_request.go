package requests

import (
    "errors"
    "strings"

    "API/models"
    "gorm.io/gorm" 
)

type LoginRequest struct {
    Identifier string `json:"identifier" binding:"required"`
    Password   string `json:"password" binding:"required"`
}

func (lr *LoginRequest) Authenticate(db *gorm.DB) (*models.User, error) {
    var user models.User
    if strings.Contains(lr.Identifier, "@") {
        if err := db.Where("email = ?", lr.Identifier).First(&user).Error; err != nil {
            return nil, errors.New("user not found")
        }
    } else {
        if err := db.Where("nis = ? OR nip = ?", lr.Identifier, lr.Identifier).First(&user).Error; err != nil {
            return nil, errors.New("user not found")
        }
    }
    if !CheckPassword(user, lr.Password) {
        return nil, errors.New("authentication failed")
    }

    return &user, nil
}
func CheckPassword(user models.User, password string) bool {
    return user.Password == password 
}