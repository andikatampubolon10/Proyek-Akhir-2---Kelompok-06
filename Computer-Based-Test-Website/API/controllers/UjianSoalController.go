package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetUjianSoals(c *gin.Context) {
    var ujianSoals []models.UjianSoal
    config.DB.Find(&ujianSoals)
    c.JSON(http.StatusOK, gin.H{"data": ujianSoals})
}

func GetUjianSoal(c *gin.Context) {
    var ujianSoal models.UjianSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujianSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": ujianSoal})
}

func CreateUjianSoal(c *gin.Context) {
    var input models.UjianSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateUjianSoal(c *gin.Context) {
    var ujianSoal models.UjianSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujianSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.UjianSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&ujianSoal).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": ujianSoal})
}

func DeleteUjianSoal(c *gin.Context) {
    var ujianSoal models.UjianSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujianSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&ujianSoal)
    c.JSON(http.StatusOK, gin.H{"data": true})
}