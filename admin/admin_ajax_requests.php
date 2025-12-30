<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/admin_auth_guard.php');
require_once(__DIR__ . '/../includes/db.php');

if (requestIsAJAX()) {
    $q = $_GET["q"];
    if ($q == "USERNAME_EXISTS") {
        $username = $_POST["username"];
        $data['response'] = usernameExists($username, $con);
        echo json_encode($data);
        exit;
    } elseif ($q == "EMAIL_EXISTS") {
        $email = $_POST["email"];
        $data['response'] = emailExists($email, $con);
        echo json_encode($data);
        exit;
    } elseif ($q == "STUDENT_NUMBER_EXISTS") {
        $studentNumber = $_POST["studentNumber"];
        $data['response'] = studentNumberExists($studentNumber, $con);
        echo json_encode($data);
        exit;
    }
}

function usernameExists($username, $con)
{
    // Check username is exist in the database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        return true;
    }
    return false;
}

function emailExists($email, $con)
{
    // Check email is exist in the database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        return true;
    }
    return false;
}

function studentNumberExists($studentNumber, $con)
{
    // Check student number is exist in the database
    $query = "SELECT * FROM students WHERE student_number=$studentNumber";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        return true;
    }
    return false;
}

function requestIsAJAX()
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }
    return false;
}
