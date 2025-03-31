package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetLatihanSoals(c *gin.Context) {
    var latihanSoals []models.LatihanSoal
    config.DB.Find(&latihanSoals)
    c.JSON(http.StatusOK, gin.H{"data": latihanSoals})
}

func GetLatihanSoal(c *gin.Context) {
    var latihanSoal models.LatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": latihanSoal})
}

func CreateLatihanSoal(c *gin.Context) {
    var input models.LatihanSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateLatihanSoal(c *gin.Context) {
    var latihanSoal models.LatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.LatihanSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&latihanSoal).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": latihanSoal})
}

func DeleteLatihanSoal(c *gin.Context) {
    var latihanSoal models.LatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&latihanSoal)
    c.JSON(http.StatusOK, gin.H{"data": true})
}