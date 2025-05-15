package controller

import (
	"cbt-api/config" // Import konfigurasi DB
	"cbt-api/entity" // Import entitas Kursus
	"net/http"

	"github.com/gin-gonic/gin"
)

// GetAllKursus will return all the course records.
func GetAllKursus(c *gin.Context) {
	var kursusList []entity.Kursus

	// Retrieve all courses from the database
	err := config.DB.Find(&kursusList).Error
	if err != nil {
		// Return error if there is an issue with the database query
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Unable to retrieve courses"})
		return
	}

	// Return the list of courses in JSON format
	c.JSON(http.StatusOK, gin.H{
		"message": "Kursus retrieved successfully",
		"kursus": kursusList,
	})
}
