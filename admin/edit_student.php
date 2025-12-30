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

$userId = null;
$firstName = "";
$lastName = "";
$email = "";
$studentNumber = null;
$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GET method: Show the data of student
    if (!isset($_GET["userId"])) {
        header("Location: /student_grade_management_system/admin/list_students.php");
        exit;
    }
    $userId = $_GET["userId"];
    // read the row of the selected student from database table
    $query = "SELECT users.email, users.first_name, users.last_name, students.* FROM students " .
        "INNER JOIN users ON students.user_id=users.id " .
        "WHERE users.deleted=0 AND students.deleted=0 AND students.user_id=" . $userId;
    $result = mysqli_query($con, $query);
    $student = mysqli_fetch_assoc($result);
    if (!$student) {
        header("Location: /student_grade_management_system/admin/list_students.php");
        exit;
    }
    $firstName = $student["first_name"];
    $lastName = $student["last_name"];
    $email = $student["email"];
    $studentNumber = $student["student_number"];
} else {
    // POST method: Update the data of student
    $userId = $_POST["userId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $updatedAt = date("Y-m-d H:i:s");
    do {
        if (empty($userId) || empty($firstName) || empty($lastName)) {
            $errorMessage = "All the fields are required";
            break;
        }
        $query = "UPDATE users " .
            "SET first_name='$firstName', last_name='$lastName', updated_at='$updatedAt' " .
            "WHERE id=$userId";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $firstName = "";
        $lastName = "";
        $email = "";
        $studentNumber = null;

        $successMessage = "Student updated correctly";
        header("Location: /student_grade_management_system/admin/list_students.php");
        exit;
    } while (false);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>

    <div class="header">
        <div class="menu">
            <strong><?= $_SESSION['roleName'] . ": " . $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            <a class="link-primary" href="/student_grade_management_system/admin/logout.php">Logout</a>
        </div>
    </div>

    <div class="main">
        <div class="left-side-bar">
            <div>
                <ul>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_professors.php">List Of Professors</a></li>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_courses.php">List Of Courses</a></li>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_students.php">List Of Students</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <h2>Edit Student</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="editStudentForm" method="POST">
                    <input type="hidden" name="userId" value="<?= $userId ?>">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?= $firstName ?>">
                    <div id="firstNameError" class="invalid-input"></div>
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?= $lastName ?>">
                    <div id="lastNameError" class="invalid-input"></div>
                    <label for="email">Email <span class="muted small">(as username)</span></label>
                    <input type="text" id="email" name="email" value="<?= $email ?>" readonly>
                    <div id="emailError" class="invalid-input"></div>
                    <label for="studentNumber">Student Number <span class="muted small">(only integer numbers - length must be 9)</span></label>
                    <input type="text" id="studentNumber" name="studentNumber" value="<?= $studentNumber ?>" readonly>
                    <div id="studentNumberError" class="invalid-input"></div>
                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="editStudentFormSubmit" class="btn btn-primary">Submit</button>
                    <a href="/student_grade_management_system/admin/list_students.php" class="btn btn-secondary ">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/admin/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>

    <script src="/student_grade_management_system/assets/js/common/util.js"></script>
    <script src="/student_grade_management_system/assets/js/admin/edit_student.js"></script>

</body>

</html>