<?php
$host = 'localhost';
$db = 'students_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// retrieve student ID from the URL
$student_id = $_GET['id'];

// retching student details
$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = $conn->query($sql);

// fetch student courses
$course_sql = "SELECT c.course_name FROM courses c 
               JOIN student_courses sc ON c.course_id = sc.course_id 
               WHERE sc.student_id = '$student_id'";
$course_result = $conn->query($course_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student Details</title>
    <style>
    body {
        background-color: #f8f9fa;
    }

    .student-card {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .course-list {
        list-style-type: none;
        padding-left: 0;
    }

    .course-list li {
        padding: 5px 0;
    }

    .btn-custom {
        background-color: #8EACCD;
        /* Button color */
        color: #fff;
        /* Text color */
    }

    .btn-custom:hover {
        background-color: #BAC8EB;
        /* Hover color */
        color: #fff;
        /* Text color on hover */
    }

    h2 {
        color: #8EACCD;
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center ">Student Details</h2>
        <div class="student-card">
            <?php
            if ($result->num_rows > 0) {
                $student = $result->fetch_assoc();
            ?>
            <h4><?php echo $student['name'] . ' ' . $student['surname']; ?></h4>
            <p><strong>Age:</strong> <?php echo $student['age']; ?></p>
            <p><strong>Address:</strong> <?php echo $student['address']; ?></p>
            <p><strong>School Year:</strong> <?php echo $student['school_year']; ?></p>
            <p><strong>Class:</strong> <?php echo $student['class']; ?></p>
            <p><strong>Study Days:</strong> <?php echo $student['study_days']; ?></p>
            <p><strong>Program:</strong> <?php echo $student['program']; ?></p>

            <h5>Courses:</h5>
            <ul class="course-list">
                <?php
                    if ($course_result->num_rows > 0) {
                        while($course = $course_result->fetch_assoc()) {
                            echo "<li>" . $course['course_name'] . "</li>";
                        }
                    } else {
                        echo "<li>No courses found.</li>";
                    }
                    ?>
            </ul>
            <?php
            } else {
                echo "<p>No student found with that ID.</p>";
            }
            ?>
            <a href="list_students.php" class="btn btn-custom mt-3">Back to List</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
