<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BisnisOperatorController;
use App\Http\Controllers\AdminAuthController; // Tambahkan controller untuk login admin


        Route::get('operators', [OperatorController::class, 'index'])->name('listOperator');
        Route::get('operators/create', [OperatorController::class, 'create'])->name('createOperator');
        Route::post('operators', [OperatorController::class, 'store'])->name('storeOperator');
        Route::get('operators/{operator}/edit', [OperatorController::class, 'edit'])->name('editOperator');
        Route::put('operators/{operator}', [OperatorController::class, 'update'])->name('updateOperator');
        Route::delete('operators/{operator}', [OperatorController::class, 'destroy'])->name('deleteOperator');
        Route::get('bisnis-dashboard', [BisnisOperatorController::class, 'index'])->name('bisnisDashboard');
        Route::get('bisnis/create', [BisnisOperatorController::class, 'create'])->name('createBisnis');
        Route::post('bisnis/store', [BisnisOperatorController::class, 'store'])->name('storeBisnis');
        Route::delete('bisnis/{bisnis}', [BisnisOperatorController::class, 'destroy'])->name('deleteBisnis');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';