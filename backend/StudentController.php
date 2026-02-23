<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Show all students
    public function index()
    {
        return Student::all();
    }

    // Store new student
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'registration_no' => 'required|unique:students,registration_no'
        ]);

        // Create student
        Student::create($validated);

        // Redirect with success message
        return redirect()->route('students.index')
                         ->with('success', 'Student Added Successfully');
    }
}