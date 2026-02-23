<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController; // 👈 meka add karanna

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);

// Attendance Routes
Route::get('/attendance', [AttendanceController::class, 'index']);
Route::get('/attendance/mark', [AttendanceController::class, 'mark']);