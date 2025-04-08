package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetMataPelajaran(c *gin.Context) {
    var mataPelajaran []models.MataPelajaran
    config.DB.Find(&mataPelajaran)
    c.JSON(http.StatusOK, gin.H{"data": mataPelajaran})
}

func GetMataPelajaranByID(c *gin.Context) {
    var mataPelajaran models.MataPelajaran
    if err := config.DB.Where("id = ?", c.Param("id")).First(&mataPelajaran).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": mataPelajaran})
}

func CreateMataPelajaran(c *gin.Context) {
    var input models.MataPelajaran
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateMataPelajaran(c *gin.Context) {
    var mataPelajaran models.MataPelajaran
    if err := config.DB.Where("id = ?", c.Param("id")).First(&mataPelajaran).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.MataPelajaran
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&mataPelajaran).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": mataPelajaran})
}

func DeleteMataPelajaran(c *gin.Context) {
    var mataPelajaran models.MataPelajaran
    if err := config.DB.Where("id = ?", c.Param("id")).First(&mataPelajaran).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&mataPelajaran)
    c.JSON(http.StatusOK, gin.H{"data": true})
}