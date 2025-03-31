package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetKurikulum(c *gin.Context) {
    var kurikulums []models.Kurikulum
    config.DB.Find(&kurikulums)
    c.JSON(http.StatusOK, gin.H{"data": kurikulums})
}

func GetKurikulumByID(c *gin.Context) {
    var kurikulum models.Kurikulum
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kurikulum).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": kurikulum})
}

func CreateKurikulum(c *gin.Context) {
    var input models.Kurikulum
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateKurikulum(c *gin.Context) {
    var kurikulum models.Kurikulum
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kurikulum).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Kurikulum
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&kurikulum).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": kurikulum})
}

func DeleteKurikulum(c *gin.Context) {
    var kurikulum models.Kurikulum
    if err := config.DB.Where("id = ?", c.Param("id")).First(&kurikulum).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&kurikulum)
    c.JSON(http.StatusOK, gin.H{"data": true})
}