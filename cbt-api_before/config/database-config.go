package config

import (
	"cbt-api/entity"
	"fmt"

	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

var DB *gorm.DB

func ConnectDatabase() {
	dsn := "root:@tcp(127.0.0.1:3306)/getkursus?charset=utf8mb4&parseTime=True&loc=Local"
	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		fmt.Println("Gagal konek ke database:", err)
	}

	DB = db

	err = db.AutoMigrate(
	// 	&entity.JawabanSiswa{},
	// 	&entity.MataPelajaranSiswa{},
	// 	&entity.MataPelajaran{},
	// 	&entity.KurikulumSiswa{},
	// 	&entity.Kurikulum{},
		&entity.KursusSiswa{},
	// 	&entity.Kursus{},
		&entity.Siswa{},
    //     &entity.Users{},
	// 	&entity.Soal{},
	// 	&entity.Ujian{},
    //     &entity.TipeUjian{},
	// 	&entity.TipeSoal{},
		&entity.Kursus{},
	// 	&entity.Latihan{},
	// 	&entity.Guru{},
	// 	&entity.Kelas{},
	// 	&entity.Operator{},
	// 	&entity.Bisnis{},
    )
	// if err != nil {
	// 	fmt.Println("Gagal AutoMigrate:", err)
	// }

	fmt.Println("Koneksi dan migrasi sukses")
}
