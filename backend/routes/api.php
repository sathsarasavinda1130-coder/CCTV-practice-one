<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;

Route::post('/students', [StudentController::class, 'store']);
Route::get('/students', [StudentController::class, 'index']);

Route::post('/mark', [AttendanceController::class, 'mark']);
Route::get('/attendance', [AttendanceController::class, 'index']);