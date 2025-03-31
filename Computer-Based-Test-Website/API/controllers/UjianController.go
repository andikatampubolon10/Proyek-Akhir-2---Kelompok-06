package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetUjians(c *gin.Context) {
    var ujians []models.Ujian
    config.DB.Find(&ujians)
    c.JSON(http.StatusOK, gin.H{"data": ujians})
}

func GetUjian(c *gin.Context) {
    var ujian models.Ujian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": ujian})
}

func CreateUjian(c *gin.Context) {
    var input models.Ujian
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateUjian(c *gin.Context) {
    var ujian models.Ujian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Ujian
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&ujian).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": ujian})
}

func DeleteUjian(c *gin.Context) {
    var ujian models.Ujian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&ujian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&ujian)
    c.JSON(http.StatusOK, gin.H{"data": true})
}