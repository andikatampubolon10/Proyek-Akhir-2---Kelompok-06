// controllers/guru_controller.go
package controllers

import (
	"API/config"
	"API/models"
	"net/http"
	"github.com/xuri/excelize/v2"
	"github.com/gin-gonic/gin"
)

func ImportGuru(c *gin.Context) {
	// Mengambil file dari permintaan
	file, err := c.FormFile("file")
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "File tidak valid"})
		return
	}

	// Membaca file Excel
	f, err := excelize.OpenFile(file.Filename)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal membuka file Excel"})
		return
	}

	// Mengambil data dari sheet pertama
	rows, err := f.GetRows(f.GetSheetName(0))
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal membaca data dari file Excel"})
		return
	}

	// Menyimpan data guru ke dalam slice
	var gurus []models.Guru
	for _, row := range rows {
		if len(row) < 3 {
			continue // Lewati baris yang tidak lengkap
		}
		gurus = append(gurus, models.Guru{
			Name:     row[0], // Nama guru
			NIP:      row[1], // NIP guru
			Password: row[2], // Password guru
		})
	}

	// Menyimpan data guru ke database
	for _, guru := range gurus {
		if err := config.DB.Create(&guru).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal menyimpan data guru ke database"})
			return
		}
	}

	c.JSON(http.StatusOK, gin.H{"message": "Data guru berhasil diimpor"})
}

func GetGurus(c *gin.Context) {
	var gurus []models.Guru
	config.DB.Find(&gurus)
	c.JSON(http.StatusOK, gin.H{"data": gurus})
}

func GetGuru(c *gin.Context) {
	var guru models.Guru
	if err := config.DB.Where("id = ?", c.Param("id")).First(&guru).Error; err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
		return
	}
	c.JSON(http.StatusOK, gin.H{"data": guru})
}

func CreateGuru(c *gin.Context) {
	var input models.Guru
	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	config.DB.Create(&input)
	c.JSON(http.StatusOK, gin.H{"data": input})
}

func ImportGurus(c *gin.Context) {
	var gurus []models.Guru
	if err := c.ShouldBindJSON(&gurus); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	for _, guru := range gurus {
		var existingGuru models.Guru
		if err := config.DB.Where("nip = ?", guru.NIP).First(&existingGuru).Error; err == nil {
			c.JSON(http.StatusBadRequest, gin.H{"error": "NIP " + guru.NIP + " sudah ada di tabel guru."})
			return
		}
		config.DB.Create(&guru)
	}

	c.JSON(http.StatusOK, gin.H{"data": gurus})
}

func UpdateGuru(c *gin.Context) {
	var guru models.Guru
	if err := config.DB.Where("id = ?", c.Param("id")).First(&guru).Error; err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
		return
	}
	var input models.Guru
	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	config.DB.Model(&guru).Updates(input)
	c.JSON(http.StatusOK, gin.H{"data": guru})
}

func DeleteGuru(c *gin.Context) {
	var guru models.Guru
	if err := config.DB.Where("id = ?", c.Param("id")).First(&guru).Error; err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
		return
	}
	config.DB.Delete(&guru)
	c.JSON(http.StatusOK, gin.H{"data": true})
}
