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
$email = "";
$password = "";
$errorMessage = "";
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $creator = $_SESSION["userId"];
    $roleId = getRoleId('Professor', $con);
    $createdAt = date("Y-m-d H:i:s");
    do {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            $errorMessage = "All the fields are required";
            break;
        }
        // add new professor to database
        $query = "INSERT INTO users (creator, role_id, first_name, last_name, email, password, created_at) " .
            "VALUES ($creator, $roleId, '$firstName', '$lastName', '$email', md5($password), '$createdAt')";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }

        $firstName = "";
        $lastName = "";
        $email = "";
        $password = "";

        $successMessage = "Student added correctly";
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
    <title>Add Professor</title>
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
                <h2>Add Professor</h2>
                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <strong><?= $errorMessage ?></strong>
                    </div>
                <?php } ?>

                <form id="addProfessorForm" method="POST">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?= $firstName ?>">
                    <div id="firstNameError" class="invalid-input"></div>
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?= $lastName ?>">
                    <div id="lastNameError" class="invalid-input"></div>
                    <label for="email">Email <span class="muted small">(as username)</span></label>
                    <input type="email" name="email" id="email" value="<?= $email ?>">
                    <div id="emailError" class="invalid-input"></div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <div id="passwordError" class="invalid-input"></div>
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword">
                    <div id="confirmPasswordError" class="invalid-input"></div>
                    <?php if (!empty($successMessage)) { ?>
                        <strong><?= $successMessage ?></strong>
                    <?php } ?>
                    <button type="submit" id="addProfessorFormSubmit" class="btn btn-primary">Submit</button>
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


    <script src="/student_grade_management_system/assets/js/admin/add_professor.js"></script>

</body>

</html>