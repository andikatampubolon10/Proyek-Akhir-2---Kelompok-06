package controllers

import (
	"os"
	"API/models"
	"API/requests"
	"github.com/dgrijalva/jwt-go" 
	"github.com/gin-gonic/gin"
	"net/http"
	"time"
	"API/config" 
)

func ShowLoginForm(c *gin.Context) {
	c.HTML(http.StatusOK, "login.blade.php", nil) 
}

func HandleLogin(c *gin.Context) {
	var loginRequest requests.LoginRequest

	if err := c.ShouldBindJSON(&loginRequest); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	user, err := loginRequest.Authenticate(config.DB) // Mengoper DB ke Authenticate
	if err != nil {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Authentication failed"})
		return
	}

	token, err := GenerateJWT(*user) // Menggunakan dereference untuk mendapatkan nilai
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to generate token"})
		return
	}

	c.JSON(http.StatusOK, gin.H{"token": token, "redirect": getRedirectURL(user)})
}

func GenerateJWT(user models.User) (string, error) {
	// Membuat klaim JWT
	token := jwt.NewWithClaims(jwt.SigningMethodHS256, jwt.MapClaims{
		"user_id": user.ID,
		"exp":     time.Now().Add(time.Hour * 72).Unix(),
	})

	secretKey := []byte(os.Getenv("JWT_SECRET_KEY"))
	if secretKey == nil {
		return "", http.ErrNoLocation 
	}


	return token.SignedString(secretKey)
}

func getRedirectURL(user *models.User) string {
	if user.HasRole("Admin") {
		return "/Admin/Akun"
	} else if user.HasRole("Guru") {
		return "/Guru/Course"
	} else if user.HasRole("Siswa") {
		return "/Siswa/Course"
	} else if user.HasRole("Operator") {
		return "/Operator/Siswa"
	}
	return "/dashboard"
}

func Logout(c *gin.Context) {
	c.JSON(http.StatusOK, gin.H{"message": "Logout successful"})
}