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

$gradeAppealId = null;
$title = "";
$description = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GET method: Show the data of course
    if (!isset($_GET["gradeAppealId"])) {
        header("Location: /student_grade_management_system/admin/list_grades.php");
        exit;
    }
    $gradeAppealId = $_GET["gradeAppealId"];
    // read the row of the selected grade appeal from database table
    $query = "SELECT * FROM grade_appeal WHERE id=$gradeAppealId ";
    try {
        $result = mysqli_query($con, $query);
        $gradeAppeal = mysqli_fetch_assoc($result);
        if (!$gradeAppeal) {
            header("Location: /student_grade_management_system/admin/list_grades.php");
            exit;
        }

        if (!$gradeAppeal["read_by_professor"]) {
            $query = "UPDATE grade_appeal " .
                "SET read_by_professor=1 " .
                "WHERE id=$gradeAppealId";
            mysqli_query($con, $query);
        }


        $title = $gradeAppeal["title"];
        $description = $gradeAppeal["description"];
    } catch (mysqli_sql_exception $exception) {
        $errorMessage = $exception->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Grade Appeal</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <header class="header">
        <div class="menu">
            <strong><?= $_SESSION['roleName'] . ": " . $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            <a class="" href="/student_grade_management_system/admin/logout.php">Logout</a>
        </div>
    </header>
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
                <h2 style="margin-bottom: 0.5em;">Read Grade Appeal</h2>
                <hr>
                <form id="viewGradeAppealForm">
                    <input type="hidden" name="gradeAppealId" value="<?= $gradeAppealId ?>">
                    <!-- <label for="title">title <span class="muted small">(readonly)</span></label>
                    <input type="text" id="title" name="title" value="" readonly>
                    <div id="titleError" class="invalid-input"></div> -->

                    <!-- <label for="description">Description <span class="muted small">(readonly)</span></label>
                    <textarea name="description" id="description" cols="30" rows="10" readonly></textarea>
                    <div id="descriptionError" class="invalid-input"></div> -->



                    <h3><?= $title ?></h3>
                    <div style="margin-bottom: 2em;">
                        <p style="line-height: 1.5em;"><?= $description ?></p>
                    </div>

                    <div>
                        <a href="/student_grade_management_system/admin/list_grades.php" class="btn btn-secondary ">Back</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/admin/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>


    <!-- <script src="/student_grade_management_system/assets/js/student/view_grade_appeal.js"></script> -->

</body>

</html>