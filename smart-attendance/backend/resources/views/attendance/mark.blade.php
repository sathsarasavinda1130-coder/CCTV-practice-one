<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
</head>
<body>

<h2>Mark Attendance</h2>

@if(isset($students) && count($students) > 0)

<form method="POST" action="/attendance/mark">
    @csrf

    <select name="student_id">
        @foreach($students as $student)
            <option value="{{ $student->id }}">
                {{ $student->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Mark Present</button>

</form>

@else

<p>No students found.</p>

@endif

</body>
</html>