<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\BisnisController;
use App\Http\Controllers\AttemptController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\JawabanSiswaLatihanSoalController;
use App\Http\Controllers\JawabanSiswaQuizController;
use App\Http\Controllers\JawabanSiswaUjianController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\LatihanSoalController;
use App\Http\Controllers\LatihanSoalSoalController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UjianSoalController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JawabanSoalUjianController;
use App\Http\Controllers\JawabanSoalQuizController;
use App\Http\Controllers\JawabanLatihanSoalController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Halaman dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Route untuk profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Admin
    Route::prefix('Admin')->name('Admin.')->middleware('role:Admin')->group(function () {
        Route::resource('/Akun', OperatorController::class)->parameters(['Akun' => 'user']);
        Route::get('/Admin/Akun/{id}/edit', [AkunController::class, 'edit'])->name('Admin.Akun.edit');
        Route::resource('/Bisnis', BisnisController::class);
    });
    

    // Route untuk Guru
    Route::prefix('Guru')->name('Guru.')->middleware('role:Guru')->group(function () {
        Route::resource('/Course', CourseController::class);
        Route::resource('/Siswa', SiswaController::class);
        Route::resource('/LatihanSoal', LatihanSoalController::class);
        Route::resource('/LatihanSoalSoal', LatihanSoalSoalController::class);
        Route::resource('/Kelas', KelasController::class);
        Route::resource('/MataPelajaran', MataPelajaranController::class);
        Route::resource('/Quiz', QuizController::class);
        Route::resource('/QuizSoal', QuizSoalController::class);
        Route::resource('/Ujian', UjianController::class);
        Route::resource('/UjianSoal', UjianSoalController::class);
        Route::resource('/Kurikulum', KurikulumController::class);
        Route::resource('/Attempt', AttemptController::class);
        Route::resource('/JawabanSiswaLatihanSoal', JawabanSiswaLatihanSoalController::class);
        Route::resource('/JawabanSiswaQuiz', JawabanSiswaQuizController::class);
        Route::resource('/JawabanSiswaUjian', JawabanSiswaUjianController::class);
    });

    // Route untuk Operator
    Route::prefix('Operator')->name('Operator.')->middleware('role:Operator')->group(function () {
        Route::resource('/Guru', GuruController::class);
        Route::get('/Guru/upload', [GuruController::class, 'upload'])->name('Guru.upload');
        Route::post('/Guru/import', [GuruController::class, 'import'])->name('Guru.import');

        Route::resource('/Siswa', SiswaController::class);
        Route::get('/Siswa/upload', [SiswaController::class, 'upload'])->name('Siswa.upload');
        Route::post('/Siswa/import', [SiswaController::class, 'import'])->name('Siswa.import');

        Route::resource('/Kelas', KelasController::class);
        Route::resource('/Kurikulum', KurikulumController::class);
        Route::resource('/MataPelajaran', MataPelajaranController::class);
    });

    // Route untuk Siswa
    Route::prefix('Siswa')->name('Siswa.')->middleware('role:Siswa')->group(function () {
        Route::resource('/Course', CourseController::class);
        Route::resource('/Quiz', QuizController::class);
        Route::resource('/JawabanSiswaQuiz', JawabanSiswaQuizController::class);
        Route::resource('/Ujian', UjianController::class);
        Route::resource('/JawabanSiswaUjian', JawabanSiswaUjianController::class);
        Route::resource('/LatihanSoal', LatihanSoalController::class);
        Route::resource('/JawabanSiswaLatihanSoal', JawabanSiswaLatihanSoalController::class);
        Route::resource('/MataPelajaran', MataPelajaranController::class);
        Route::resource('/Kurikulum', KurikulumController::class);
        Route::resource('/Kelas', KelasController::class);
        Route::resource('/Profil', ProfilController::class);
    });
});

// Route untuk logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';