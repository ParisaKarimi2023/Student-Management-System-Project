<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/student_auth_guard.php');

if (!in_array(getSession("roleName"), ["Student"])) {
    header("Location: /student_grade_management_system/common/403.php");
    exit;
}
require_once(__DIR__ . '/../includes/db.php');

$errorMessage = "";
$successMessage = "";
$studentId = getStudentId(getSession("userId"), $con);
$courses = getNotSelectedCoursesByStudent($studentId, $con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $_POST["course"];
    $createdAt = date("Y-m-d H:i:s");
    $updatedAt = date("Y-m-d H:i:s");
    $deleted = 0;
    do {
        if (empty($courseId)) {
            $errorMessage = "All the fields are required";
            break;
        }
        if (courseAlreadyDeleted($studentId, $courseId, $con)) {
            // update course 
            $query = "UPDATE course_student " .
                "SET deleted=0, updated_at='$updatedAt' " .
                "WHERE course_id=$courseId AND student_id=$studentId";
        } else {
            // add new course to database
            $query = "INSERT INTO course_student (course_id, student_id, created_at, deleted) " .
                "VALUES ($courseId, $studentId, '$createdAt', $deleted)";
        }

        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $courseIdId = null;

        $successMessage = "Course selected correctly";
        header("Location: /student_grade_management_system/student/my_selected_courses.php");
        exit;
    } while (false);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header">
        <div class="menu">
            <strong><?= $_SESSION['roleName'] . ": " . $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            <a class="" href="/student_grade_management_system/student/logout.php">Logout</a>
        </div>
    </header>
    <div class="main">
        <div class="left-side-bar">
            <div>
                <ul>
                    <li><a href="http://localhost/student_grade_management_system/student/my_selected_courses.php">My Selected Courses</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <h2>Select Course</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="selectCourseForm" method="POST">
                    <label for="course">Course</label>
                    <select name="course" id="course">
                        <option value="">Select a course</option>
                        <?php foreach ($courses as $course) {  ?>
                            <option value="<?= $course["id"] ?>"><?= $course["title"] ?></option>
                        <?php } ?>
                    </select>
                    <div id="courseError" class="invalid-input"></div>

                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="selectCourseFormSubmit" class="btn btn-primary">Submit</button>
                    <a href="/student_grade_management_system/student/my_selected_courses.php" class="btn btn-secondary ">Cancel</a>
                </form>
            </div>
        </div>

    </div>
    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/student/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>


    <!-- <script src="/student_grade_management_system/assets/js/common/util.js"></script> -->
    <script src="/student_grade_management_system/assets/js/student/select_course.js"></script>

</body>

</html>