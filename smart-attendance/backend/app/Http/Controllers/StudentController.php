<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function store(Request $request)
    {
        Student::create($request->only([
            'name',
            'email',
            'registration_no'
        ]));

        return redirect()->route('students.index');
    }
}