package routes

import (
    "API/controllers"
    "API/middleware"
    "github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
    r := gin.Default()

    // Rute utama untuk login
    r.GET("/", controllers.ShowLoginForm)
    r.POST("/", controllers.HandleLogin)

    // Rute untuk Admin
    r.GET("/Admin/Akun", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.GetOperators)
    r.GET("/Admin/Akun/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.GetOperator)
    r.POST("/Admin/Akun", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.CreateOperator)
    r.PUT("/Admin/Akun/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.UpdateOperator)
    r.DELETE("/Admin/Akun/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.DeleteOperator)

    r.GET("/Admin/Bisnis", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.GetBisnis)
    r.GET("/Admin/Bisnis/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.GetBisnisByID)
    r.POST("/Admin/Bisnis", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.CreateBisnis)
    r.PUT("/Admin/Bisnis/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.UpdateBisnis)
    r.DELETE("/Admin/Bisnis/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Admin"), controllers.DeleteBisnis)

    r.GET("/Guru/Course", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetCourses)
    r.GET("/Guru/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetCourse)
    r.POST("/Guru/Course", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateCourse)
    r.PUT("/Guru/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateCourse)
    r.DELETE("/Guru/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteCourse)

    r.GET("/Guru/Siswa", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetSiswa)
    r.GET("/Guru/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetSiswaByID)
    r.POST("/Guru/Siswa", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateSiswa)
    r.PUT("/Guru/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateSiswa)
    r.DELETE("/Guru/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteSiswa)

    r.GET("/Guru/LatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetLatihanSoals)
    r.GET("/Guru/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetLatihanSoal)
    r.POST("/Guru/LatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateLatihanSoal)
    r.PUT("/Guru/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateLatihanSoal)
    r.DELETE("/Guru/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteLatihanSoal)

    r.GET("/Guru/LatihanSoalSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetLatihanSoalSoals)
    r.GET("/Guru/LatihanSoalSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetLatihanSoalSoal)
    r.POST("/Guru/LatihanSoalSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateLatihanSoalSoal)
    r.PUT("/Guru/LatihanSoalSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateLatihanSoalSoal)
    r.DELETE("/Guru/LatihanSoalSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteLatihanSoalSoal)

    r.GET("/Guru/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetKelas)
    r.GET("/Guru/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetKelasByID)
    r.POST("/Guru/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateKelas)
    r.PUT("/Guru/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateKelas)
    r.DELETE("/Guru/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteKelas)

    r.GET("/Guru/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetMataPelajaran)
    r.GET("/Guru/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetMataPelajaranByID)
    r.POST("/Guru/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateMataPelajaran)
    r.PUT("/Guru/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateMataPelajaran)
    r.DELETE("/Guru/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteMataPelajaran)

    r.GET("/Guru/Quiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetQuizzes)
    r.GET("/Guru/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetQuiz)
    r.POST("/Guru/Quiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateQuiz)
    r.PUT("/Guru/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateQuiz)
    r.DELETE("/Guru/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteQuiz)

    r.GET("/Guru/QuizSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetQuizSoals)
    r.GET("/Guru/QuizSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetQuizSoal)
    r.POST("/Guru/QuizSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateQuizSoal)
    r.PUT("/Guru/QuizSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateQuizSoal)
    r.DELETE("/Guru/QuizSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteQuizSoal)

    r.GET("/Guru/Ujian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetUjians)
    r.GET("/Guru/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetUjian)
    r.POST("/Guru/Ujian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateUjian)
    r.PUT("/Guru/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateUjian)
    r.DELETE("/Guru/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteUjian)

    r.GET("/Guru/UjianSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetUjianSoals)
    r.GET("/Guru/UjianSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetUjianSoal)
    r.POST("/Guru/UjianSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateUjianSoal)
    r.PUT("/Guru/UjianSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateUjianSoal)
    r.DELETE("/Guru/UjianSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteUjianSoal)

    r.GET("/Guru/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetKurikulum)
    r.GET("/Guru/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetKurikulumByID)
    r.POST("/Guru/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateKurikulum)
    r.PUT("/Guru/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateKurikulum)
    r.DELETE("/Guru/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteKurikulum)

    r.GET("/Guru/JawabanSiswaLatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaLatihanSoals)
    r.GET("/Guru/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaLatihanSoal)
    r.POST("/Guru/JawabanSiswaLatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateJawabanSiswaLatihanSoal)
    r.PUT("/Guru/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateJawabanSiswaLatihanSoal)
    r.DELETE("/Guru/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteJawabanSiswaLatihanSoal)

    r.GET("/Guru/JawabanSiswaQuiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaQuizzes)
    r.GET("/Guru/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaQuiz)
    r.POST("/Guru/JawabanSiswaQuiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateJawabanSiswaQuiz)
    r.PUT("/Guru/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateJawabanSiswaQuiz)
    r.DELETE("/Guru/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteJawabanSiswaQuiz)

    r.GET("/Guru/JawabanSiswaUjian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaUjians)
    r.GET("/Guru/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.GetJawabanSiswaUjian)
    r.POST("/Guru/JawabanSiswaUjian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.CreateJawabanSiswaUjian)
    r.PUT("/Guru/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.UpdateJawabanSiswaUjian)
    r.DELETE("/Guru/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Guru"), controllers.DeleteJawabanSiswaUjian)

    r.GET("/Operator/Guru", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetGurus)
    r.GET("/Operator/Guru/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetGuru)
    r.POST("/Operator/Guru", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.CreateGuru)
    r.PUT("/Operator/Guru/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.UpdateGuru)
    r.DELETE("/Operator/Guru/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.DeleteGuru)
    r.POST("/Operator/Guru/import", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.ImportGuru)

    r.GET("/Operator/Siswa", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetSiswa)
    r.GET("/Operator/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetSiswaByID)
    r.POST("/Operator/Siswa", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.CreateSiswa)
    r.PUT("/Operator/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.UpdateSiswa)
    r.DELETE("/Operator/Siswa/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.DeleteSiswa)
    r.POST("/Operator/Siswa/import", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.ImportSiswa)

    r.GET("/Operator/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetKelas)
    r.GET("/Operator/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetKelasByID)
    r.POST("/Operator/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.CreateKelas)
    r.PUT("/Operator/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.UpdateKelas)
    r.DELETE("/Operator/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.DeleteKelas)

    r.GET("/Operator/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetKurikulum)
    r.GET("/Operator/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetKurikulumByID)
    r.POST("/Operator/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.CreateKurikulum)
    r.PUT("/Operator/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.UpdateKurikulum)
    r.DELETE("/Operator/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.DeleteKurikulum)

    r.GET("/Operator/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetMataPelajaran)
    r.GET("/Operator/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.GetMataPelajaranByID)
    r.POST("/Operator/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.CreateMataPelajaran)
    r.PUT("/Operator/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.UpdateMataPelajaran)
    r.DELETE("/Operator/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Operator"), controllers.DeleteMataPelajaran)

    r.GET("/Siswa/Course", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetCourses)
    r.GET("/Siswa/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetCourse)
    r.POST("/Siswa/Course", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateCourse)
    r.PUT("/Siswa/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateCourse)
    r.DELETE("/Siswa/Course/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteCourse)

    r.GET("/Siswa/Quiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetQuizzes)
    r.GET("/Siswa/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetQuiz)
    r.POST("/Siswa/Quiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateQuiz)
    r.PUT("/Siswa/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateQuiz)
    r.DELETE("/Siswa/Quiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteQuiz)

    r.GET("/Siswa/JawabanSiswaQuiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaQuizzes)
    r.GET("/Siswa/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaQuiz)
    r.POST("/Siswa/JawabanSiswaQuiz", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateJawabanSiswaQuiz)
    r.PUT("/Siswa/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateJawabanSiswaQuiz)
    r.DELETE("/Siswa/JawabanSiswaQuiz/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteJawabanSiswaQuiz)

    r.GET("/Siswa/Ujian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetUjians)
    r.GET("/Siswa/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetUjian)
    r.POST("/Siswa/Ujian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateUjian)
    r.PUT("/Siswa/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateUjian)
    r.DELETE("/Siswa/Ujian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteUjian)

    r.GET("/Siswa/JawabanSiswaUjian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaUjians)
    r.GET("/Siswa/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaUjian)
    r.POST("/Siswa/JawabanSiswaUjian", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateJawabanSiswaUjian)
    r.PUT("/Siswa/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateJawabanSiswaUjian)
    r.DELETE("/Siswa/JawabanSiswaUjian/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteJawabanSiswaUjian)

    r.GET("/Siswa/LatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetLatihanSoals)
    r.GET("/Siswa/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetLatihanSoal)
    r.POST("/Siswa/LatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateLatihanSoal)
    r.PUT("/Siswa/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateLatihanSoal)
    r.DELETE("/Siswa/LatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteLatihanSoal)

    r.GET("/Siswa/JawabanSiswaLatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaLatihanSoals)
    r.GET("/Siswa/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetJawabanSiswaLatihanSoal)
    r.POST("/Siswa/JawabanSiswaLatihanSoal", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateJawabanSiswaLatihanSoal)
    r.PUT("/Siswa/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateJawabanSiswaLatihanSoal)
    r.DELETE("/Siswa/JawabanSiswaLatihanSoal/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteJawabanSiswaLatihanSoal)

    r.GET("/Siswa/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetMataPelajaran)
    r.GET("/Siswa/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetMataPelajaranByID)
    r.POST("/Siswa/MataPelajaran", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateMataPelajaran)
    r.PUT("/Siswa/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateMataPelajaran)
    r.DELETE("/Siswa/MataPelajaran/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteMataPelajaran)

    r.GET("/Siswa/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetKurikulum)
    r.GET("/Siswa/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetKurikulumByID)
    r.POST("/Siswa/Kurikulum", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateKurikulum)
    r.PUT("/Siswa/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateKurikulum)
    r.DELETE("/Siswa/Kurikulum/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteKurikulum)

    r.GET("/Siswa/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetKelas)
    r.GET("/Siswa/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.GetKelasByID)
    r.POST("/Siswa/Kelas", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.CreateKelas)
    r.PUT("/Siswa/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.UpdateKelas)
    r.DELETE("/Siswa/Kelas/:id", middleware.AuthMiddleware(), middleware.RoleMiddleware("Siswa"), controllers.DeleteKelas)

    // Rute untuk logout
    r.POST("/logout", controllers.Logout)

    return r
}