package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetJawabanSiswaUjians(c *gin.Context) {
    var jawabanSiswaUjians []models.JawabanSiswaUjian
    config.DB.Find(&jawabanSiswaUjians)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaUjians})
}

func GetJawabanSiswaUjian(c *gin.Context) {
    var jawabanSiswaUjian models.JawabanSiswaUjian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaUjian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaUjian})
}

func CreateJawabanSiswaUjian(c *gin.Context) {
    var input models.JawabanSiswaUjian
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateJawabanSiswaUjian(c *gin.Context) {
    var jawabanSiswaUjian models.JawabanSiswaUjian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaUjian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.JawabanSiswaUjian
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&jawabanSiswaUjian).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaUjian})
}

func DeleteJawabanSiswaUjian(c *gin.Context) {
    var jawabanSiswaUjian models.JawabanSiswaUjian
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaUjian).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&jawabanSiswaUjian)
    c.JSON(http.StatusOK, gin.H{"data": true})
}