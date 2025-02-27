<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

<<<<<<< Updated upstream
Route::get('/', function () {
    return view('guru.index');
});
=======
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
>>>>>>> Stashed changes
