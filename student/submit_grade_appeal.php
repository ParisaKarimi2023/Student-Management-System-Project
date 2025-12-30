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

// $professorId = null;
$courseStudentId = null;
$title = "";
$description = "";
$errorMessage = "";
$successMessage = "";
// $professors = getProfessors($con);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // GET method: Show the data of course
        if (!isset($_GET["selectedCourseId"])) {
            header("Location: /student_grade_management_system/student/my_selected_courses.php");
            exit;
        }
        $courseStudentId = $_GET["selectedCourseId"];
}elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $professorId = $_POST["professor"];
    $courseStudentId = $_POST["courseStudentId"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $readByProfessor = 0;
    // $creator = $_SESSION["userId"];
    $createdAt = date("Y-m-d H:i:s");
    // $deleted = 0;
    do {
        if (empty($courseStudentId) || empty($title) || empty($description)) {
            $errorMessage = "All the fields are required";
            break;
        }
        // add new course to database
        $query = "INSERT INTO grade_appeal (course_student_id, title, description, read_by_professor, created_at) " .
            "VALUES ($courseStudentId, '$title', '$description', $readByProfessor, '$createdAt')";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $title = "";
        $description = "";

        $successMessage = "Grade Appeal submited correctly";
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
    <title>Submit Grade Appeal</title>
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
                <h2>Submit Grade Appeal</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="submitGradeAppealForm" method="POST">
                <input type="hidden" name="courseStudentId" value="<?= $courseStudentId ?>">
                    <label for="title">title</label>
                    <input type="text" id="title" name="title" value="<?= $title ?>">
                    <div id="titleError" class="invalid-input"></div>

                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"><?= $description ?></textarea>
                    <div id="descriptionError" class="invalid-input"></div>
                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="submitGradeAppealFormSubmit" class="btn btn-primary">Submit</button>
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


    <script src="/student_grade_management_system/assets/js/student/submit_grade_appeal.js"></script>

</body>

</html>