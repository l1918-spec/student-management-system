<?php
$host = 'localhost';
$db = 'students_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// delete a student 
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . $conn->error;
    }
    $stmt->close();
}

// add a new student 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $school_year = $_POST['school_year'];
    $class = $_POST['class'];
    $study_days = $_POST['study_days'];
    $program = $_POST['program'];

    $stmt = $conn->prepare("INSERT INTO students (name, surname, age, address, school_year, class, study_days, program) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssss", $name, $surname, $age, $address, $school_year, $class, $study_days, $program);

    if ($stmt->execute()) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Search for a student by ID
$search_result = null;
if (isset($_GET['search_id'])) {
    $search_id = $_GET['search_id'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $search_id);
    $stmt->execute();
    $search_result = $stmt->get_result();
    $stmt->close();
}

// Fetch all students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f4f9fc;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #8EACCD;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-view,
    .btn-edit {
        background-color: #8EACCD;
        color: floralwhite;
        transition: background-color 0.3s, transform 0.2s;
        border: none;
    }

    .btn-view:hover {
        background-color: #BAC8EB;
        transform: translateY(-3px);
    }

    .btn-edit:hover {
        background-color: #BAC8EB;
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: #8EACCD;
        color: white;
        border: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-delete:hover {
        background-color: #BAC8EB;
        transform: translateY(-3px);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fdfdfd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    thead {
        background-color: #6A9BC1;
        color: white;
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #6A9BC1;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    th {
        font-size: 16px;
        font-weight: 500;
    }

    td {
        font-size: 14px;
    }

    .table a {
        text-decoration: none;
        color: black;
    }

    .table a:hover {
        color: #6A9BC1;
    }

    .input-group input {
        border-radius: 5px 0 0 5px;
    }

    .input-group button {
        border-radius: 0 5px 5px 0;
    }

    .alert {
        border-radius: 5px;
    }

    .text-center a {
        margin-top: 20px;
        text-decoration: none;
    }

    @media (max-width: 768px) {

        th,
        td {
            font-size: 12px;
        }

        .container {
            padding: 15px;
        }
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">List of Students</h2>

        <form method="GET" action="list_students.php" class="mb-4">
            <div class="input-group mb-3">
                <input type="text" name="search_id" class="form-control" placeholder="Search for Student ID" required>
                <button type="submit" class="btn btn-custom">Search</button>
            </div>
        </form>

        <?php if ($search_result && $search_result->num_rows > 0) {
            $student = $search_result->fetch_assoc();
            echo "<div class='alert alert-success'>Student Found: " . htmlspecialchars($student['name']) . " " . htmlspecialchars($student['surname']) . "</div>";
            echo "<div class='alert alert-info'>";
            echo "<strong>Student Details:</strong><br>";
            echo "ID: " . htmlspecialchars($student['student_id']) . "<br>";
            echo "Name: " . htmlspecialchars($student['name']) . "<br>";
            echo "Surname: " . htmlspecialchars($student['surname']) . "<br>";
            echo "Age: " . htmlspecialchars($student['age']) . "<br>";
            echo "Address: " . htmlspecialchars($student['address']) . "<br>";
            echo "School Year: " . htmlspecialchars($student['school_year']) . "<br>";
            echo "Class: " . htmlspecialchars($student['class']) . "<br>";
            echo "Study Days: " . htmlspecialchars($student['study_days']) . "<br>";
            echo "Program: " . htmlspecialchars($student['program']) . "<br>";
            echo "</div>";
        } elseif ($search_result) {
            echo "<div class='alert alert-danger'>No student found with ID: " . htmlspecialchars($search_id) . "</div>";
        } ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td><a href='view_student.php?id=" . $row['student_id'] . "' style='color: black;'>" . htmlspecialchars($row['name']) . "</a></td>";
                    echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['class']) . "</td>";
                    echo "<td>";
                    echo "<a href='view_student.php?id=" . $row['student_id'] . "' class='btn btn-view btn-sm'>View</a> ";
                    echo "<a href='edit_student.php?id=" . $row['student_id'] . "' class='btn btn-edit btn-sm'>Edit</a> ";
                    echo "<a href='list_students.php?delete_id=" . $row['student_id'] . "' class='btn btn-delete btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No students found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="add_student.php" class="btn btn-view">Add New Student</a>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>