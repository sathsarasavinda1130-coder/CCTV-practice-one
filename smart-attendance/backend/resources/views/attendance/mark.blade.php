<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<form method="POST" action="/students" enctype="multipart/form-data">
    @csrf

    <!-- Student Name -->
    <div>
        <label>Student Name:</label><br>
        <input type="text" name="name" placeholder="Enter Name" required>
    </div>

    <br>

    <!-- Email -->
    <div>
        <label>Email:</label><br>
        <input type="email" name="email" placeholder="Enter Email" required>
    </div>

    <br>

    <!-- Registration Number -->
    <div>
        <label>Registration No:</label><br>
        <input type="text" name="registration_no" placeholder="Enter Reg No" required>
    </div>

    <br>

    <!-- Photo Upload -->
    <div>
        <label>Photo:</label><br>
        <input type="file" name="photo">
    </div>

    <br>

    <!-- Branch Dropdown -->
    <div>
        <label>Select Branch:</label><br>
        <select name="branch_id" required>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button type="submit">Save Student</button>

</form>

</body>
</html>