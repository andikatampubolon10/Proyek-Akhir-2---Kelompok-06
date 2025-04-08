package migrations

import (
	"API/models"
	"gorm.io/gorm"
)

func RunMigrations(db *gorm.DB) error {
	err := db.AutoMigrate(&models.User{}, &models.Role{}, &models.Permission{})
	if err != nil {
		return err
	}
	return nil
}