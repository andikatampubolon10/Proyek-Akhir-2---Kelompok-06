package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetQuizzes(c *gin.Context) {
    var quizzes []models.Quiz
    config.DB.Find(&quizzes)
    c.JSON(http.StatusOK, gin.H{"data": quizzes})
}

func GetQuiz(c *gin.Context) {
    var quiz models.Quiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": quiz})
}

func CreateQuiz(c *gin.Context) {
    var input models.Quiz
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateQuiz(c *gin.Context) {
    var quiz models.Quiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Quiz
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&quiz).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": quiz})
}

func DeleteQuiz(c *gin.Context) {
    var quiz models.Quiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&quiz)
    c.JSON(http.StatusOK, gin.H{"data": true})
}