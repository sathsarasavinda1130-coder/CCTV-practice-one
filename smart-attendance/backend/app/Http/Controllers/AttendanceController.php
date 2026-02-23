<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show attendance form page
    public function showForm()
    {
        return view('attendance.mark');
    }

    // Handle attendance mark (Check-in / Check-out)
    public function mark(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('student_id', $request->student_id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {

            // First time → Check In
            $attendance = Attendance::create([
                'student_id' => $request->student_id,
                'date' => $today,
                'check_in' => Carbon::now()->format('H:i:s'),
            ]);

            return redirect()->back()->with('success', 'Check-in successful');

        } else {

            // Already checked in → Check Out
            $attendance->update([
                'check_out' => Carbon::now()->format('H:i:s'),
            ]);

            return redirect()->back()->with('success', 'Check-out successful');
        }
    }
}