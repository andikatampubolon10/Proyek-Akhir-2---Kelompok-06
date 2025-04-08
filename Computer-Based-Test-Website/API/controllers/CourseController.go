package controllers

import (
    "API/models"
    "API/config"
    "net/http"
    "github.com/gin-gonic/gin"
)

func GetCourses(c *gin.Context) {
    var courses []models.Course
    config.DB.Find(&courses)
    c.JSON(http.StatusOK, gin.H{"data": courses})
}

func GetCourse(c *gin.Context) {
    var course models.Course
    if err := config.DB.Where("id = ?", c.Param("id")).First(&course).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": course})
}

func CreateCourse(c *gin.Context) {
    var input models.Course
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateCourse(c *gin.Context) {
    var course models.Course
    if err := config.DB.Where("id = ?", c.Param("id")).First(&course).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Course
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&course).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": course})
}

func DeleteCourse(c *gin.Context) {
    var course models.Course
    if err := config.DB.Where("id = ?", c.Param("id")).First(&course).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&course)
    c.JSON(http.StatusOK, gin.H{"data": true})
}