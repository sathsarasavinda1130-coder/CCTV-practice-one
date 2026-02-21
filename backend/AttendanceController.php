<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function mark(Request $request)
    {
        return Attendance::create(['student_id' => $request->student_id]);
    }

    public function index()
    {
        return Attendance::all();
    }
}