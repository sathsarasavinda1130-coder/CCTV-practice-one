<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show attendance mark form
    public function showForm()
    {
        $students = Student::orderBy('name')->get();
        return view('attendance.mark', compact('students'));
    }

    // Mark Check-in / Check-out
    public function mark(Request $request)
    {
        // ✅ Basic Validation
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
        ], [
            'student_id.required' => 'Please select a student.',
            'student_id.exists'   => 'Selected student does not exist.',
        ]);

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');

        // ✅ Prevent future date manipulation (extra safety)
        if ($now->isFuture()) {
            return back()->with('error', 'Invalid system time.');
        }

        // ✅ Check if record already exists today
        $attendance = Attendance::where('student_id', $request->student_id)
            ->whereDate('date', $today)
            ->first();

        // ===============================
        // FIRST SCAN → CHECK-IN
        // ===============================
        if (!$attendance) {

            // Optional: Prevent too-early check-in (example before 5 AM)
            if ($now->hour < 5) {
                return back()->with('error', 'Check-in not allowed at this time.');
            }

            Attendance::create([
                'student_id' => $request->student_id,
                'date'       => $today,
                'check_in'   => $currentTime,
            ]);

            return back()->with('success', 'Check-in successful');
        }

        // ===============================
        // PREVENT MULTIPLE CHECK-OUT
        // ===============================
        if ($attendance->check_out) {
            return back()->with('error', 'Attendance already completed for today.');
        }

        // Prevent checkout within 1 minute of check-in
        $checkInTime = Carbon::createFromFormat('H:i:s', $attendance->check_in);
        if ($checkInTime->diffInSeconds($now) < 60) {
            return back()->with('error', 'Check-out not allowed within 1 minute of check-in.');
        }

        // ===============================
        // SECOND SCAN → CHECK-OUT
        // ===============================
        $attendance->update([
            'check_out' => $currentTime,
        ]);

        return back()->with('success', 'Check-out successful');
    }

    // Attendance List Page
    public function index()
    {
        $attendances = Attendance::with('student')
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->get();
        $attendances = Attendance::all();
        return view('attendance.index', compact('attendances'));
    }
}