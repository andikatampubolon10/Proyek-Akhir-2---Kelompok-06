// models/user.go
package models

import (
	"gorm.io/gorm"
)

// User - Struktur untuk pengguna
type User struct {
	gorm.Model // Menyertakan gorm.Model untuk ID, CreatedAt, UpdatedAt, DeletedAt
	Email      string      `json:"email"`
	Password   string      `json:"password"`
	Roles      []Role      `json:"roles" gorm:"many2many:user_roles;"`
	Permissions []Permission `json:"permissions" gorm:"many2many:user_permissions;"`
}

// Role - Struktur untuk peran
type Role struct {
	ID          uint        `json:"id" gorm:"primaryKey"`
	Name        string      `json:"name"`
	Permissions []Permission `json:"permissions" gorm:"many2many:role_permissions;"`
}

// Permission - Struktur untuk izin
type Permission struct {
	ID   uint   `json:"id" gorm:"primaryKey"`
	Name string `json:"name"`
}

// HasRole - Memeriksa apakah pengguna memiliki peran tertentu
func (u *User ) HasRole(roleName string) bool {
	for _, role := range u.Roles {
		if role.Name == roleName {
			return true
		}
	}
	return false
}

// HasPermission - Memeriksa apakah pengguna memiliki izin tertentu
func (u *User ) HasPermission(permissionName string) bool {
	for _, permission := range u.Permissions {
		if permission.Name == permissionName {
			return true
		}
	}
	return false
}