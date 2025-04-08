package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetJawabanSiswaLatihanSoals(c *gin.Context) {
    var jawabanSiswaLatihanSoals []models.JawabanSiswaLatihanSoal
    config.DB.Find(&jawabanSiswaLatihanSoals)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaLatihanSoals})
}

func GetJawabanSiswaLatihanSoal(c *gin.Context) {
    var jawabanSiswaLatihanSoal models.JawabanSiswaLatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaLatihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaLatihanSoal})
}

func CreateJawabanSiswaLatihanSoal(c *gin.Context) {
    var input models.JawabanSiswaLatihanSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateJawabanSiswaLatihanSoal(c *gin.Context) {
    var jawabanSiswaLatihanSoal models.JawabanSiswaLatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaLatihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.JawabanSiswaLatihanSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&jawabanSiswaLatihanSoal).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaLatihanSoal})
}

func DeleteJawabanSiswaLatihanSoal(c *gin.Context) {
    var jawabanSiswaLatihanSoal models.JawabanSiswaLatihanSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaLatihanSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&jawabanSiswaLatihanSoal)
    c.JSON(http.StatusOK, gin.H{"data": true})
}