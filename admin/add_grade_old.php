<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/admin_auth_guard.php');

if (!in_array(getSession("roleName"), ["Admin"])) {
    header("Location: /student_grade_management_system/common/403.php");
    exit;
}
require_once(__DIR__ . '/../includes/db.php');

$firstName = "";
$lastName = "";
$username = "";
$email = "";
$password = "";
$grade = null;
$errorMessage = "";
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $course = $_POST["course"];
    $grade = $_POST["grade"];
    $userId = $_SESSION["userId"];
    $createdAt = date("Y-m-d H:i:s");
    do {
        if (empty($name) || empty($course) || empty($grade)) {
            $errorMessage = "All the fields are required";
            break;
        }
        // add new student to database
        $query = "INSERT INTO students (user_id, name, course, grade, created_at) " .
            "VALUES ($userId, '$name', '$course', $grade, '$createdAt')";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $name = "";
        $course = "";
        $grade = "";

        $successMessage = "Student added correctly";
        header("Location: /student_grade_management_system/dashboard");
        exit;
    } while (false);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="menu">
        <strong><?= $_SESSION['username']; ?></strong>
        <a href="/student_grade_management_system/logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Add Student</h2>
        <?php if (!empty($errorMessage)) { ?>
            <div class="error-message">
                <strong><?= $errorMessage ?></strong>
            </div>
        <?php } ?>

        <form id="addStudentForm" method="POST">
            <label for="sname">Student Name</label>
            <input type="text" id="name" name="name" value="<?= $name ?>">
            <div id="nameError" class="invalid-input"></div>
            <label for="scourse">Student Course</label>
            <input type="text" id="course" name="course" value="<?= $course ?>">
            <div id="courseError" class="invalid-input"></div>
            <label for="sgrade">Student Grade <span class="muted small">(only decimal and integers from 0 to 100)</span></label>
            <input type="text" id="grade" name="grade" value="<?= $grade ?>">
            <div id="gradeError" class="invalid-input"></div>
            <?php if (!empty($successMessage)) { ?>
                <strong><?= $successMessage ?></strong>
            <?php } ?>
            <button type="submit" id="addStudentFormSubmit" class="btn btn-primary">Submit</button>
            <a href="/student_grade_management_system/dashboard" class="btn btn-secondary ">Cancel</a>
        </form>
    </div>
    <script src="/student_grade_management_system/assets/js/util.js"></script>
    <script src="/student_grade_management_system/assets/js/add_student.js"></script>

</body>

</html>