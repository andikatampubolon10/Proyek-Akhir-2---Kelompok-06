// controllers/siswa_controller.go
package controllers

import (
	"API/config"
	"API/models"
	"net/http"
	"github.com/xuri/excelize/v2"
	"github.com/gin-gonic/gin"
)

// ImportSiswa - Menangani import data siswa dari file Excel
func ImportSiswa(c *gin.Context) {
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

	// Menyimpan data siswa ke dalam slice
	var siswas []models.Siswa
	for _, row := range rows {
		if len(row) < 3 {
			continue // Lewati baris yang tidak lengkap
		}
		siswas = append(siswas, models.Siswa{
			Name:     row[0], // Nama siswa
			NIS:      row[1], // NIS siswa
			Password: row[2], // Password siswa
		})
	}

	// Menyimpan data siswa ke database
	for _, siswa := range siswas {
		if err := config.DB.Create(&siswa).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal menyimpan data siswa ke database"})
			return
		}
	}

	c.JSON(http.StatusOK, gin.H{"message": "Data siswa berhasil diimpor"})
}

func GetSiswa(c *gin.Context) {
    var siswa []models.Siswa
    config.DB.Find(&siswa)
    c.JSON(http.StatusOK, gin.H{"data": siswa})
}

func GetSiswaByID(c *gin.Context) {
    var siswa models.Siswa
    if err := config.DB.Where("id = ?", c.Param("id")).First(&siswa).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    c.JSON(http.StatusOK, gin.H{"data": siswa})
}

func CreateSiswa(c *gin.Context) {
    var input models.Siswa
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Create(&input)
    c.JSON(http.StatusOK, gin.H{"data": input})
}

func UpdateSiswa(c *gin.Context) {
    var siswa models.Siswa
    if err := config.DB.Where("id = ?", c.Param("id")).First(&siswa).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    var input models.Siswa
    if err := c.ShouldBindJSON(&input); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return
    }
    config.DB.Model(&siswa).Updates(input)
    c.JSON(http.StatusOK, gin.H{"data": siswa})
}

func DeleteSiswa(c *gin.Context) {
    var siswa models.Siswa
    if err := config.DB.Where("id = ?", c.Param("id")).First(&siswa).Error; err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "Record not found!"})
        return
    }
    config.DB.Delete(&siswa)
    c.JSON(http.StatusOK, gin.H{"data": true})
}