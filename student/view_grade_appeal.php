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

$gradeAppealId = null;
$title = "";
$description = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GET method: Show the data of course
    if (!isset($_GET["gradeAppealId"])) {
        header("Location: /student_grade_management_system/student/my_selected_courses.php");
        exit;
    }
    $gradeAppealId = $_GET["gradeAppealId"];
    // read the row of the selected grade appeal from database table
    $query = "SELECT * FROM grade_appeal WHERE id=$gradeAppealId ";
    $result = mysqli_query($con, $query);
    $gradeAppeal = mysqli_fetch_assoc($result);
    if (!$gradeAppeal) {
        header("Location: /student_grade_management_system/student/my_selected_courses.php");
        exit;
    }
    $title = $gradeAppeal["title"];
    $description = $gradeAppeal["description"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grade Appeal</title>
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
                <h2 style="margin-bottom: 0.5em;">View Grade Appeal</h2>
                <hr>
                <form id="viewGradeAppealForm" method="POST">
                    <input type="hidden" name="gradeAppealId" value="<?= $gradeAppealId ?>">
                    <!-- <label for="title">title <span class="muted small">(readonly)</span></label>
                    <input type="text" id="title" name="title" value="" readonly>
                    <div id="titleError" class="invalid-input"></div> -->

                    <!-- <label for="description">Description <span class="muted small">(readonly)</span></label>
                    <textarea name="description" id="description" cols="30" rows="10" readonly></textarea>
                    <div id="descriptionError" class="invalid-input"></div> -->



                    <h3><?= $title ?></h3>
                    <div style="margin-bottom: 2em;"><p style="line-height: 1.5em;"><?= $description ?></p></div>
                    
                    <div>
                    <a href="/student_grade_management_system/student/my_selected_courses.php" class="btn btn-secondary ">Back</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/student/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>


    <!-- <script src="/student_grade_management_system/assets/js/student/view_grade_appeal.js"></script> -->

</body>

</html>