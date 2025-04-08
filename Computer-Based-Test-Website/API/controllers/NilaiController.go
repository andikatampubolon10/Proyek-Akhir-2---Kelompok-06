package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetNilais(c *gin.Context) {
    var nilais []models.Nilai
    config.DB.Find(&nilais)
    c.JSON(http.StatusOK, gin.H{"data": nilais})
}

func GetNilai(c *gin.Context) {
    var nilai models.Nilai
    if err := config.DB.Where("id = ?", c.Param("id")).First(&nilai).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": nilai})
}

func CreateNilai(c *gin.Context) {
    var input models.Nilai
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateNilai(c *gin.Context) {
    var nilai models.Nilai
    if err := config.DB.Where("id = ?", c.Param("id")).First(&nilai).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Nilai
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&nilai).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": nilai})
}

func DeleteNilai(c *gin.Context) {
    var nilai models.Nilai
    if err := config.DB.Where("id = ?", c.Param("id")).First(&nilai).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&nilai)
    c.JSON(http.StatusOK, gin.H{"data": true})
}