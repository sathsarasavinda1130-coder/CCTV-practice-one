<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);

// Attendance Routes
Route::get('/attendance', [AttendanceController::class, 'showForm']);
Route::post('/attendance/mark', [AttendanceController::class, 'mark']);

// (optional) auto API route
Route::post('/attendance/auto', [AttendanceController::class, 'autoMark']);