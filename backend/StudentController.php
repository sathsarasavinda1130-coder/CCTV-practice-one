<?php
namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        return Student::create($request->only(['name','email']));
    }
    public function index()
    {
        return Student::all();
    }
}