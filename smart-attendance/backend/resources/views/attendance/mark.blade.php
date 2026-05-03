<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
</head>
<body>

<h2>Mark Attendance</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<!-- MANUAL FORM -->
<form method="POST" action="/attendance/mark">
    @csrf

    <label>Select Student:</label><br>

    <select name="student_id" required>
        <option value="">-- Select Student --</option>
        @foreach($students as $student)
            <option value="{{ $student->id }}">
                {{ $student->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">Mark Attendance</button>
</form>

<hr>

<!-- AUTO BUTTON (simulate camera scan) -->
<h3>Auto Scan (Simulation)</h3>

<form method="POST" action="/attendance/auto">
    @csrf

    <input type="number" name="student_id" placeholder="Enter ID (simulate scan)" required>

    <button type="submit">Auto Mark</button>
</form>

</body>
</html>