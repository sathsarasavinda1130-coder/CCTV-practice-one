<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show Form
    public function showForm()
    {
        $students = Student::orderBy('name')->get();
        return view('attendance.mark', compact('students'));
    }

    // ===============================
    // MANUAL MARK
    // ===============================
    public function mark(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        return $this->processAttendance($request->student_id);
    }

    // ===============================
    // AUTO MARK (API / CAMERA)
    // ===============================
    public function autoMark(Request $request)
    {
        // example: student_id from face recognition
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student ID not detected'
            ]);
        }

        return $this->processAttendance($studentId);
    }

    // ===============================
    // COMMON LOGIC
    // ===============================
    private function processAttendance($studentId)
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $time = $now->format('H:i:s');

        $attendance = Attendance::where('student_id', $studentId)
            ->whereDate('date', $today)
            ->first();

        // CHECK-IN
        if (!$attendance) {
            Attendance::create([
                'student_id' => $studentId,
                'date' => $today,
                'check_in' => $time,
            ]);

            return back()->with('success', 'Check-in successful');
        }

        // Already checked out
        if ($attendance->check_out) {
            return back()->with('error', 'Already completed today');
        }

        // CHECK-OUT
        $attendance->update([
            'check_out' => $time,
        ]);

        return back()->with('success', 'Check-out successful');
    }

    // ===============================
    // ATTENDANCE LIST PAGE
    // ===============================
    public function index()
    {
        $attendances = Attendance::with('student')
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->get();

        return view('attendance.index', compact('attendances'));
    }
}