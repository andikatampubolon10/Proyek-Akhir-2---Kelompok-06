package main

import (

	"github.com/gin-gonic/gin"
	"cbt-api/config"
	"cbt-api/controller"
	"cbt-api/service"
	"cbt-api/repository"
)

func main() {
	db := config.ConnectDatabase() 

	// Inisialisasi Gin router
	r := gin.Default()

	jawabanSiswaRepo := repository.NewJawabanSiswaRepository(db)

	// 4. Init Service
	jawabanSiswaService := service.NewJawabanSiswaService(jawabanSiswaRepo)
	jwtService := service.NewJWTService()

	// Inisialisasi controller dengan service
	jawabanSiswaController := controller.NewJawabanSiswaController(jawabanSiswaService, jwtService)

	// Setup routes untuk jawaban siswa
	setupRoutes(r, jawabanSiswaController)

	// Rute lainnya
	r.POST("/login", controller.Login)
	r.GET("/kursus-siswa/:id_siswa", controller.GetKursusBySiswa)
	r.GET("/ujian-materi-kursus/:id_kursus", controller.GetUjianAndMateriByKursus)
	r.GET("/profil/:id_siswa", controller.GetSiswaWithKelas)
	r.GET("/kelas", controller.GetAllKelas)
	r.GET("/kurikulum", controller.GetAllKurikulum)
	r.POST("/login-ujian/:id_ujian", controller.AccessUjian)
	r.GET("/soal/:id_soal", controller.GetSoalWithJawaban)
	r.GET("/soal-ujian/:id_ujian", controller.GetSoalByUjian)
	r.GET("/mata-pelajaran/:id_kurikulum", controller.GetMataPelajaranByKurikulum)
	r.GET("/all-kursus", controller.GetAllKursus)
	r.GET("/kursus/:id_kursus", controller.GetKursusById)
	r.POST("/kursus/access/:id_kursus", controller.EnrollKursus)
	r.POST("/kursus_siswa/enroll", controller.EnrollKursusSiswa)

	// Jalankan server
	r.Run("192.168.56.1:8080")
}

// Daftarkan semua endpoint jawaban siswa ke router utama
func setupRoutes(router *gin.Engine, jawabanSiswaController controller.JawabanSiswaController) {
	jawabanSiswaRoutes := router.Group("api/jawaban-siswa")
	{
		jawabanSiswaRoutes.POST("/", jawabanSiswaController.CreateJawabanSiswa)
		jawabanSiswaRoutes.POST("/batch", jawabanSiswaController.CreateBatchJawabanSiswa)
		jawabanSiswaRoutes.GET("/:id", jawabanSiswaController.GetJawabanSiswaByID)
		jawabanSiswaRoutes.GET("/siswa/:id_siswa", jawabanSiswaController.GetJawabanSiswaBySiswaID)
		jawabanSiswaRoutes.GET("/ujian/:id_ujian", jawabanSiswaController.GetJawabanSiswaByUjianID)
	}
}
