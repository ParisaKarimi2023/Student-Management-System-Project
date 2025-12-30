<?php
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include('already_logged_in.php');
include_once(__DIR__ . '/../filters/admin_already_logged_in.php');
require_once(__DIR__ . '/../includes/db.php');

$username = "";
$password = "";
$errorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    do {
        if (empty($username) || empty($password)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Check user is exist in the database
        // $username = mysqli_real_escape_string($con, $username);
        $query = "SELECT users.id, users.first_name, users.last_name, users.email, roles.name as role_name FROM users " .
        "INNER JOIN roles ON users.role_id=roles.id " .
        "WHERE users.email='$username' " .
            "AND users.password='" . md5($password) . "'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $user = mysqli_fetch_assoc($result);
            loadBaseSession($user);
            // Redirect to user admin page
            header("Location: /student_grade_management_system/admin");
            exit;
        } else {
            $errorMessage = "Incorrect Username/password.";
            break;
        }
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h2>Admin Login</span></h2>
        <?php if (!empty($errorMessage)) { ?>
            <div class="error-message">
                <strong><?= $errorMessage ?></strong>
            </div>
        <?php } ?>
        <form id="loginForm" method="POST">
            <label for="username">Username <span class="muted smaill">(Email)</span></label>
            <input type="text" id="username" name="username">
            <div id="usernameError" class="invalid-input"></div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <div id="passwordError" class="invalid-input"></div>
            <button type="submit" id="loginFormSubmit" class="btn btn-primary">Login</button>
            <!-- <span class="link">Don't have an account? <a href="/student_grade_management_system/registration.php">Registration Now</a></span> -->
        </form>
    </div>
    <script src="/student_grade_management_system/assets/js/common/login.js"></script>
</body>

</html>