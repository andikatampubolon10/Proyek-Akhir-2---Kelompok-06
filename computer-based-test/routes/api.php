<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;


Route::resource('/Course/{id}', CourseController::class);