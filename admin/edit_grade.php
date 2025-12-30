<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/admin_auth_guard.php');
if (!in_array(getSession("roleName"), ["Professor"])) {
    header("Location: /student_grade_management_system/common/403.php");
    exit;
}
require_once(__DIR__ . '/../includes/db.php');

$gradeId = null;
$course = "";
$grade = null;
$student = "";
$createdAt = "";
$updatedAt = "";
$errorMessage = "";
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GET method: Show the data of garde
    if (!isset($_GET["gradeId"])) {
        header("Location: /student_grade_management_system/admin/list_grades.php");
        exit;
    }
    $gradeId = $_GET["gradeId"];
    // read the row of the selected grade from database table
    $query    = "SELECT courses.title as course, CONCAT(users.first_name, ' ', users.last_name) as student, course_student.* FROM course_student " .
        "INNER JOIN courses ON course_student.course_id=courses.id " .
        "INNER JOIN students ON course_student.student_id=students.id " .
        "INNER JOIN users ON students.user_id=users.id " .
        "WHERE course_student.deleted=0 AND course_student.id=$gradeId AND courses.professor_id=" . getSession("userId");
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header("Location: /student_grade_management_system/admin/list_grades.php");
        exit;
    }

    $course = $row["course"];
    $student = $row["student"];
    $grade = $row["grade"];
    $createdAt = $row["created_at"];
    $updatedAt = $row["updated_at"];
} else {
    // POST method: Update the data of grade
    $gradeId = $_POST["gradeId"];
    $grade = $_POST["grade"];
    $updatedAt = date("Y-m-d H:i:s");
    do {
        if (empty($gradeId) || !isset($grade)) {
            $errorMessage = "All the fields are required";
            break;
        }
        $query = "UPDATE course_student " .
            "SET grade=$grade, updated_at='$updatedAt' " .
            "WHERE id=$gradeId";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $grade = "";

        $successMessage = "Grade updated correctly";
        header("Location: /student_grade_management_system/admin/list_grades.php");
        exit;
    } while (false);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grade</title>
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
                    <li><a href="http://localhost/student_grade_management_system/admin/list_grades.php">List Of Grades</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <h2>Edit Grade</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="editGradeForm" method="POST">
                    <input type="hidden" name="gradeId" value="<?= $gradeId ?>">

                    <label for="student">Student <span class="muted small">(readonly)</span></label>
                    <input type="text" id="student" name="student" value="<?= $student ?>" readonly>
                    <div id="studentError" class="invalid-input"></div>

                    <label for="course">Course <span class="muted small">(readonly)</span></label>
                    <input type="text" id="course" name="course" value="<?= $course ?>" readonly>
                    <div id="courseError" class="invalid-input"></div>

                    <label for="createdAt">Created At <span class="muted small">(readonly)</span></label>
                    <input type="text" id="createdAt" name="createdAt" value="<?= date('Y-m-d', strtotime($createdAt)) ?>" readonly>
                    <div id="createdAtError" class="invalid-input"></div>

                    <label for="updateAt">Updated At <span class="muted small">(readonly)</span></label>
                    <input type="text" id="updateAt" name="updateAt" value="<?= date('Y-m-d', strtotime($updatedAt)) ?>" readonly>
                    <div id="updateAtError" class="invalid-input"></div>

                    <label for="grade">Grade <span class="muted small">(only decimal and integers from 0 to 100)</span></label>
                    <input type="text" id="grade" name="grade" value="<?= $grade ?>">
                    <div id="gradeError" class="invalid-input"></div>





                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="editGradeFormSubmit" class="btn btn-primary">Submit</button>
                    <a href="/student_grade_management_system/admin/list_grades.php" class="btn btn-secondary ">Cancel</a>
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
    <script src="/student_grade_management_system/assets/js/admin/edit_grade.js"></script>

</body>

</html>