package controller

import (
    "github.com/gin-gonic/gin"
    "cbt-api/config"
    "cbt-api/entity"
    "cbt-api/auth"
    "golang.org/x/crypto/bcrypt"
    "net/http"
)

func Login(c *gin.Context) {
    var userInput struct {
        Email    string `json:"email"`
        Password string `json:"password"`
    }

    // Parsing input JSON
    if err := c.ShouldBindJSON(&userInput); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid input"})
        return
    }

    // Mencari user berdasarkan email
    var user entity.Users
    if err := config.DB.Where("email = ?", userInput.Email).First(&user).Error; err != nil {
        c.JSON(http.StatusUnauthorized, gin.H{"error": "User not found"})
        return
    }

    // Membandingkan password yang dimasukkan dengan password yang disimpan
    if err := bcrypt.CompareHashAndPassword([]byte(user.Password), []byte(userInput.Password)); err != nil {
        c.JSON(http.StatusUnauthorized, gin.H{"error": "Incorrect password"})
        return
    }

    // Menghasilkan JWT token jika password benar
    token, err := auth.GenerateJWT(user.Id, user.Email)
    if err != nil {
        c.JSON(http.StatusInternalServerError, gin.H{"error": "Could not generate token"})
        return
    }

    // Mengembalikan token dan id_siswa ke client
    c.JSON(http.StatusOK, gin.H{
        "message": "Login successful",
        "token":   token,
        "id_siswa": user.Id,  // Pastikan mengembalikan id_siswa
    })
}
