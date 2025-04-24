package controller

import (
    "github.com/gin-gonic/gin"
    "cbt-api/config"
    "cbt-api/entity"
    "net/http"
)

func GetKursusBySiswa(c *gin.Context) {
    // Mendapatkan id_siswa dari parameter URL
    idSiswa := c.Param("id_siswa")

    var siswa entity.Siswa
    // Cari siswa berdasarkan id_siswa
    if err := config.DB.Where("id_siswa = ?", idSiswa).First(&siswa).Error; err != nil {
        c.JSON(http.StatusNotFound, gin.H{"error": "Siswa not found"})
        return
    }

    var kursusSiswa []entity.KursusSiswa
    // Ambil semua kursus yang dimiliki oleh siswa berdasarkan id_siswa
    if err := config.DB.Preload("Kursus").Where("id_siswa = ?", siswa.IdSiswa).Find(&kursusSiswa).Error; err != nil {
        c.JSON(http.StatusInternalServerError, gin.H{"error": "Error fetching kursus"})
        return
    }

    var kursusList []gin.H
    for _, ks := range kursusSiswa {
        // Menambahkan id_kursus, nama_kursus, password, dan image ke dalam response
        kursusList = append(kursusList, gin.H{
            "id_kursus":   ks.Kursus.IdKursus,
            "nama_kursus": ks.Kursus.NamaKursus,
            "password":    ks.Kursus.Password,  // Menambahkan password kursus
            "image":       ks.Kursus.Image,     // Menambahkan image kursus
        })
    }

    // Kirimkan hasil kursus ke client
    c.JSON(http.StatusOK, gin.H{
        "message": "Kursus retrieved successfully",
        "kursus": kursusList,
    })
}
