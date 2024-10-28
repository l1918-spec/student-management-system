<?php
$host = 'localhost';
$db = 'students_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE student_id = $student_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found";
    }
}

// updating students informations incase of errors or anything
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $school_year = $_POST['school_year'];
    $class = $_POST['class'];
    $study_days = $_POST['study_days'];
    $program = $_POST['program'];

    $sql = "UPDATE students 
            SET name = '$name', surname = '$surname', age = '$age', address = '$address', 
                school_year = '$school_year', class = '$class', study_days = '$study_days', program = '$program'
            WHERE student_id = $student_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: list_students.php");
        exit;
    } else {
        echo "Error updating student: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #F4F7F6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 700px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .container:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #8EACCD;
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
    }

    .btn-custom {
        background-color: #8EACCD;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-custom:hover {
        background-color: #D2E0FB;
        transform: translateY(-3px);
    }

    .row {
        margin-bottom: 15px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Student Information</h2>

        <form method="POST" action="edit_student.php">
            <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>"
                        required>
                </div>
                <div class="col-md-6">
                    <label>Surname</label>
                    <input type="text" name="surname" class="form-control" value="<?php echo $student['surname']; ?>"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control" value="<?php echo $student['age']; ?>"
                        required>
                </div>
                <div class="col-md-8">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $student['address']; ?>"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>School Year</label>
                    <input type="text" name="school_year" class="form-control"
                        value="<?php echo $student['school_year']; ?>" required>
                </div>
                <div class="col-md-4">
                    <label>Class</label>
                    <input type="text" name="class" class="form-control" value="<?php echo $student['class']; ?>"
                        required>
                </div>
                <div class="col-md-4">
                    <label>Study Days</label>
                    <input type="text" name="study_days" class="form-control"
                        value="<?php echo $student['study_days']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Program</label>
                    <input type="text" name="program" class="form-control" value="<?php echo $student['program']; ?>"
                        required>
                </div>
            </div>
            <button type="submit" class="btn btn-custom mt-4">Update Student</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
