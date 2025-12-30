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
$firstName = "";
$lastName = "";
$email = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GET method: Show the data of professor
    if (!isset($_GET["professorId"])) {
        header("Location: /student_grade_management_system/admin/list_professors.php");
        exit;
    }
    $professorId = $_GET["professorId"];
    // read the row of the selected professor from database table
    $query = "SELECT * FROM users WHERE id=$professorId ";
    $result = mysqli_query($con, $query);
    $professor = mysqli_fetch_assoc($result);
    if (!$professor) {
        header("Location: /student_grade_management_system/admin/list_professors.php");
        exit;
    }
    $firstName = $professor["first_name"];
    $lastName = $professor["last_name"];
    $email = $professor["email"];
} else {
    // POST method: Update the data of professor
    $professorId = $_POST["professorId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $updatedAt = date("Y-m-d H:i:s");
    do {
        if (empty($professorId) || empty($firstName) || empty($lastName)) {
            $errorMessage = "All the fields are required";
            break;
        }
        $query = "UPDATE users " .
            "SET first_name='$firstName', last_name='$lastName', updated_at='$updatedAt' " .
            "WHERE id=$professorId";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $firstName = "";
        $lastName = "";
        $email = "";

        $successMessage = "Professor updated correctly";
        header("Location: /student_grade_management_system/admin/list_professors.php");
        exit;
    } while (false);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Professor</title>
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
                <h2>Edit Professor</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="editProfessorForm" method="POST">
                    <input type="hidden" name="professorId" value="<?= $professorId ?>">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?= $firstName ?>">
                    <div id="firstNameError" class="invalid-input"></div>
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?= $lastName ?>">
                    <div id="lastNameError" class="invalid-input"></div>
                    <label for="email">Email <span class="muted small">(as username)</span></label>
                    <input type="text" id="email" name="email" value="<?= $email ?>" readonly>
                    <div id="emailError" class="invalid-input"></div>
                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="editProfessorFormSubmit" class="btn btn-primary">Submit</button>
                    <a href="/student_grade_management_system/admin/list_professors.php" class="btn btn-secondary ">Cancel</a>
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
    <script src="/student_grade_management_system/assets/js/admin/edit_professor.js"></script>

</body>

</html>