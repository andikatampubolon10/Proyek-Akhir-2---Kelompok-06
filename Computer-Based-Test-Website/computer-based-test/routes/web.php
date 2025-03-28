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
Route::get('/dashboard', function (){
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Admin
    Route::prefix('Admin')->name('Admin.')->group(function(){
        Route::resource('/Akun', OperatorController::class)->parameters(['Akun' => 'user'])->middleware('role:Admin');

        Route::resource('/Bisnis', BisnisController::class)->middleware('role:Admin');
    });

    // Route untuk Guru
    Route::prefix('Guru')->name('Guru.')->group(function(){
        Route::resource('/Course', CourseController::class)->middleware('role:Guru');

        Route::resource('/Siswa', SiswaController::class)->middleware('role:Guru');

        Route::resource('/LatihanSoal', LatihanSoalController::class)->middleware('role:Guru');

        Route::resource('/LatihanSoalSoal', LatihanSoalSoalController::class)->middleware('role:Guru');

        Route::resource('/Kelas', KelasController::class)->middleware('role:Guru');

        Route::resource('/MataPelajaran', MataPelajaranController::class)->middleware('role:Guru');

        Route::resource('/Quiz', QuizController::class)->middleware('role:Guru');
        
        Route::resource('/QuizSoal', QuizSoalController::class)->middleware('role:Guru');
        
        Route::resource('/Ujian', UjianController::class)->middleware('role:Guru');
        
        Route::resource('/UjianSoal', UjianSoalController::class)->middleware('role:Guru');
        
        Route::resource('/Kurikulum', KurikulumController::class)->middleware('role:Guru');
        
        Route::resource('/Attempt', AttemptController::class)->middleware('role:Guru');

        Route::resource('/JawabanSiswaLatihanSoal', JawabanSiswaLatihanSoalController::class)->middleware('role:Guru');

        Route::resource('/JawabanSiswaQuiz', JawabanSiswaQuizController::class)->middleware('role:Guru');
        
        Route::resource('/JawabanSiswaUjian', JawabanSiswaUjianController::class)->middleware('role:Guru');
    });

    // Route untuk Operator
    Route::prefix('Operator')->name('Operator.')->group(function(){
        Route::resource('/Guru', GuruController::class)->middleware('role:Operator');
        Route::get('/Guru/upload', [GuruController::class, 'upload'])->name('Guru.upload')->middleware('role:Operator');
        Route::post('/Guru/import', [GuruController::class, 'import'])->name('Guru.import')->middleware('role:Operator');
        Route::get('/Guru/upload', [GuruController::class, 'upload'])->name('Guru.upload')->middleware('role:Operator');
        Route::post('/Guru/import', [GuruController::class, 'import'])->name('Guru.import')->middleware('role:Operator');

        Route::resource('/Siswa', SiswaController::class)->middleware('role:Operator');
        Route::get('/Siswa/{Siswa}/edit', [SiswaController::class, 'edit'])->name('Siswa.edit')->middleware('role:Operator');
        Route::patch('/Siswa/{Siswa}', [SiswaController::class, 'update'])->name('Siswa.update')->middleware('role:Operator');
        Route::get('/Siswa/upload', [SiswaController::class, 'upload'])->name('Siswa.upload')->middleware('role:Operator');
        Route::post('/Siswa/import', [SiswaController::class, 'import'])->name('Siswa.import')->middleware('role:Operator');

        Route::resource('/Kelas', KelasController::class)->middleware('role:Operator');

        Route::resource('/Kurikulum', KurikulumController::class)->middleware('role:Operator');

        Route::resource('/MataPelajaran', MataPelajaranController::class)->middleware('role:Operator');
    });

    // Route untuk Siswa
    Route::prefix('Siswa')->name('Siswa.')->group(function(){
        Route::resource('/Course', CourseController::class)->middleware('role:Siswa');
        
        Route::resource('/Quiz', QuizController::class)->middleware('role:Siswa');
        
        Route::resource('/JawabanSiswaQuiz', JawabanSiswaQuizController::class)->middleware('role:Siswa');
        
        Route::resource('/Ujian', UjianController::class)->middleware('role:Siswa');
        
        Route::resource('/JawabanSiswaUjian', JawabanSiswaUjianController::class)->middleware('role:Siswa');
        
        Route::resource('/LatihanSoal', LatihanSoalController::class)->middleware('role:Siswa');
        
        Route::resource('/JawabanSiswaLatihanSoal', JawabanSiswaLatihanSoalController::class)->middleware('role:Siswa');
        
        Route::resource('/MataPelajaran', MataPelajaranController::class)->middleware('role:Siswa');
        
        Route::resource('/Kurikulum', KurikulumController::class)->middleware('role:Siswa');
        
        Route::resource('/Kelas', KelasController::class)->middleware('role:Siswa');
        
        Route::resource('/Profil', ProfilController::class)->middleware('role:Siswa');
    });
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';