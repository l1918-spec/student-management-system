<?php
$host = 'localhost';
$db = 'students_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $age = (int)$_POST['age'];
    $address = $conn->real_escape_string($_POST['address']);
    $school_year = $conn->real_escape_string($_POST['school_year']);
    $class = $conn->real_escape_string($_POST['class']);
    $study_days = $conn->real_escape_string($_POST['study_days']);
    $program = $conn->real_escape_string($_POST['program']);

    // Insert data into the database
    $sql = "INSERT INTO students (name, surname, age, address, school_year, class, study_days, program)
            VALUES ('$name', '$surname', $age, '$address', '$school_year', '$class', '$study_days', '$program')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f5f5f5;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        max-width: 700px;
        margin-top: 50px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #8EACCD;
        ;
        font-weight: 600;
    }

    label {
        color: #555;
        font-weight: 500;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #3282B8;
    }

    .btn-custom {
        background-color: #8EACCD;
        color: #fff;
        border: none;
        padding: 10px 20px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        border-radius: 5px;
    }

    .btn-custom:hover {
        background-color: #D2E0FB;
        ;
        transform: translateY(-3px);
    }

    .btn-custom:active {
        transform: translateY(0);
    }

    .d-flex {
        justify-content: space-between;
    }

    @media (max-width: 576px) {
        .container {
            padding: 20px;
        }

        .d-flex {
            flex-direction: column;
        }

        .d-flex a {
            margin-top: 10px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Student Registration</h2>
        <!-- Student Registration Form -->
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Enter surname"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" placeholder="Enter age" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter address"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="school_year">School Year</label>
                    <input type="text" name="school_year" id="school_year" class="form-control" placeholder="Enter year"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="class">Class</label>
                    <input type="text" name="class" id="class" class="form-control" placeholder="Enter class" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="study_days">Study Days</label>
                    <input type="text" name="study_days" id="study_days" class="form-control"
                        placeholder="Enter study days" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="program">Program</label>
                <input type="text" name="program" id="program" class="form-control" placeholder="Enter program"
                    required>
            </div>
            <div class="d-flex mt-4">
                <button type="submit" class="btn btn-custom">Add Student</button>
                <a href="list_students.php" class="btn btn-custom">View Student List</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>