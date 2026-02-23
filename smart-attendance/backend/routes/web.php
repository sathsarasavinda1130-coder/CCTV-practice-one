<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceStudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentController::class);
Route::get('/attendance/mark', [AttendanceController::class, 'mark']);
