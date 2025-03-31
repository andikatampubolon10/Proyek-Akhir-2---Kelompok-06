package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetQuizSoals(c *gin.Context) {
    var quizSoals []models.QuizSoal
    config.DB.Find(&quizSoals)
    c.JSON(http.StatusOK, gin.H{"data": quizSoals})
}

func GetQuizSoal(c *gin.Context) {
    var quizSoal models.QuizSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quizSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": quizSoal})
}

func CreateQuizSoal(c *gin.Context) {
    var input models.QuizSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateQuizSoal(c *gin.Context) {
    var quizSoal models.QuizSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quizSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.QuizSoal
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&quizSoal).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": quizSoal})
}

func DeleteQuizSoal(c *gin.Context) {
    var quizSoal models.QuizSoal
    if err := config.DB.Where("id = ?", c.Param("id")).First(&quizSoal).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&quizSoal)
    c.JSON(http.StatusOK, gin.H{"data": true})
}