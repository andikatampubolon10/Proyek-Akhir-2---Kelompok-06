package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetKelas(c *gin.Context) {
    var kelas []models.Kelas
    config.DB.Find(&kelas)
    c.JSON(http.StatusOK, gin.H{"data": kelas})
}

func GetKelasByID(c *gin.Context) {
    var kelas models.Kelas
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kelas).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": kelas})
}

func CreateKelas(c *gin.Context) {
    var input models.Kelas
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateKelas(c *gin.Context) {
    var kelas models.Kelas
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kelas).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Kelas
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&kelas).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": kelas})
}

func DeleteKelas(c *gin.Context) {
    var kelas models.Kelas
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kelas).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&kelas)
    c.JSON(http.StatusOK, gin.H{"data": true})
}