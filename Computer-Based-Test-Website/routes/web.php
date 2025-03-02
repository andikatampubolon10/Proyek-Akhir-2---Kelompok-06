<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\bisnisOperatorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('operators/create', [OperatorController::class, 'create'])->name('createOperator');
Route::post('operators', [OperatorController::class, 'store'])->name('listOperator');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('operators', [OperatorController::class, 'index'])->name('listOperator');
        Route::get('operators/create', [OperatorController::class, 'create'])->name('createOperator');
        Route::post('operators', [OperatorController::class, 'store'])->name('storeOperator');
        Route::get('operators/{operator}/edit', [OperatorController::class, 'edit'])->name('editOperator');
        Route::put('operators/{operator}', [OperatorController::class, 'update'])->name('updateOperator');
        Route::delete('operators/{operator}', [OperatorController::class, 'destroy'])->name('deleteOperator');
        Route::get('/bisnis-dashboard', [BisnisOperatorController::class, 'index'])->name('bisnisDashboard');
        Route::get('/bisnis/create', [BisnisOperatorController::class, 'create'])->name('createBisnis');
        Route::post('/bisnis/store', [BisnisOperatorController::class, 'store'])->name('storeBisnis');
        Route::delete('/bisnis/{bisnis}', [BisnisOperatorController::class, 'destroy'])->name('bisnis.destroy');
    });
});

require __DIR__.'/auth.php';