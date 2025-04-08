package controllers

import (
    "API/config"
    "API/models"
    "net/http"

    "github.com/gin-gonic/gin"
)

func GetJawabanSiswaQuizzes(c *gin.Context) {
    var jawabanSiswaQuizzes []models.JawabanSiswaQuiz
    config.DB.Find(&jawabanSiswaQuizzes)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaQuizzes})
}

func GetJawabanSiswaQuiz(c *gin.Context) {
    var jawabanSiswaQuiz models.JawabanSiswaQuiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaQuiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaQuiz})
}

func CreateJawabanSiswaQuiz(c *gin.Context) {
    var input models.JawabanSiswaQuiz
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateJawabanSiswaQuiz(c *gin.Context) {
    var jawabanSiswaQuiz models.JawabanSiswaQuiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaQuiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.JawabanSiswaQuiz
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&jawabanSiswaQuiz).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": jawabanSiswaQuiz})
}

func DeleteJawabanSiswaQuiz(c *gin.Context) {
    var jawabanSiswaQuiz models.JawabanSiswaQuiz
    if err := config.DB.Where("id = ?", c.Param("id")).First(&jawabanSiswaQuiz).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&jawabanSiswaQuiz)
    c.JSON(http.StatusOK, gin.H{"data": true})
}