package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetLatihanSoalSoals(c *gin.Context) {
    var latihanSoalSoals []models.LatihanSoalSoal
    config.DB.Find(&latihanSoalSoals)
    c.JSON(http.StatusOK, gin.H{"data": latihanSoalSoals})
}

func GetLatihanSoalSoal(c *gin.Context) {
    var latihanSoalSoal models.LatihanSoalSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoalSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": latihanSoalSoal})
}

func CreateLatihanSoalSoal(c *gin.Context) {
    var input models.LatihanSoalSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateLatihanSoalSoal(c *gin.Context) {
    var latihanSoalSoal models.LatihanSoalSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoalSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.LatihanSoalSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&latihanSoalSoal).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": latihanSoalSoal})
}

func DeleteLatihanSoalSoal(c *gin.Context) {
    var latihanSoalSoal models.LatihanSoalSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&latihanSoalSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&latihanSoalSoal)
    c.JSON(http.StatusOK, gin.H{"data": true})
}