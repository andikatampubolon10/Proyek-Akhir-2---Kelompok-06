package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)
func GetBisnis(c *gin.Context) {
    var bisnis []models.Bisnis
    config.DB.Find(&bisnis)
    c.JSON(http.StatusOK, gin.H{"data": bisnis})
}
func GetBisnisByID(c *gin.Context) {
    var bisnis models.Bisnis
    if err := config.DB.Where("id = ?", c.Param("id")).First(&bisnis).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": bisnis})
}
func CreateBisnis(c *gin.Context) {
    var input models.Bisnis
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}
func UpdateBisnis(c *gin.Context) {
    var bisnis models.Bisnis
    if err := config.DB.Where("id = ?", c.Param("id")).First(&bisnis).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Bisnis
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&bisnis).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": bisnis})
}
func DeleteBisnis(c *gin.Context) {
    var bisnis models.Bisnis
    if err := config.DB.Where("id = ?", c.Param("id")).First(&bisnis).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&bisnis)
    c.JSON(http.StatusOK, gin.H{"data": true})
}