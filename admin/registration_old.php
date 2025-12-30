<?php
include('display_errors.php');
include('already_logged_in.php');
require('db.php');

$username = "";
$email = "";
$password = "";
$errorMessage = "";
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $createdAt = date("Y-m-d H:i:s");
    do {
        if (empty($username) || empty($email) || empty($password)) {
            $errorMessage = "All the fields are required";
            break;
        }
        $query    = "INSERT into users (username, password, email, created_at)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$createdAt')";
        $result = mysqli_query($con, $query);
        if (!$result) {
            $errorMessage = "Invalid query: " . mysqli_error($con);
            break;
        }
      
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = mysqli_insert_id($con);
        $username = "";
        $email = "";
        $password = "";
        header("Location: /student_grade_management_system/dashboard");
        exit;
    } while (false);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h2>Registration</h2>
        <?php if (!empty($errorMessage)) { ?>
            <div class="error-message">
                <strong><?= $errorMessage ?></strong>
            </div>
        <?php } ?>
        <form id="registrationForm" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= $username ?>">
            <div id="usernameError" class="invalid-input"></div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $email ?>">
            <div id="emailError" class="invalid-input"></div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <div id="passwordError" class="invalid-input"></div>
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
            <div id="confirmPasswordError" class="invalid-input"></div>
            <button type="submit" id="registrationFormSubmit" class="btn btn-primary">Register</button>
            <span class="link">Already have an account? <a href="/student_grade_management_system/login.php">Login here</a></span>
        </form>
    </div>
    <script src="/student_grade_management_system/assets/js/registration.js"></script>
</body>

</html>