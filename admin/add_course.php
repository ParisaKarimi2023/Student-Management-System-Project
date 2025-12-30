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

$professorId = null;
$title = "";
$description = "";
$errorMessage = "";
$successMessage = "";
$professors = getProfessors($con);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $professorId = $_POST["professor"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $creator = $_SESSION["userId"];
    $createdAt = date("Y-m-d H:i:s");
    $deleted = 0;
    do {
        if (empty($title) || empty($description) || empty($professorId)) {
            $errorMessage = "All the fields are required";
            break;
        }
        // add new course to database
        $query = "INSERT INTO courses (creator, professor_id, title, description, created_at, deleted) " .
            "VALUES ($creator, $professorId, '$title', '$description', '$createdAt', $deleted)";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $professorId = null;
        $title = "";
        $description = "";

        $successMessage = "Course added correctly";
        header("Location: /student_grade_management_system/admin/list_courses.php");
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
            <a class="" href="/student_grade_management_system/admin/logout.php">Logout</a>
        </div>
    </header>
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
                <h2>Add Course</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="addCourseForm" method="POST">

                    <label for="title">title</label>
                    <input type="text" id="title" name="title" value="<?= $title ?>">
                    <div id="titleError" class="invalid-input"></div>

                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"><?= $description ?></textarea>
                    <div id="descriptionError" class="invalid-input"></div>

                    <label for="professor">Professor</label>
                    <select name="professor" id="professor">
                        <option value="">Select a professor</option>
                        <?php foreach ($professors as $professor) {  ?>
                            <option value="<?= $professor["id"] ?>"><?= $professor["first_name"] . " " . $professor["last_name"] ?></option>
                        <?php } ?>
                    </select>
                    <div id="professorError" class="invalid-input"></div>

                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="addCourseFormSubmit" class="btn btn-primary">Submit</button>
                    <a href="/student_grade_management_system/admin/list_courses.php" class="btn btn-secondary ">Cancel</a>
                </form>
            </div>
        </div>

    </div>
    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/admin/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>


    <script src="/student_grade_management_system/assets/js/admin/add_course.js"></script>

</body>

</html>