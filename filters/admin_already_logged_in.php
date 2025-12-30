<?php
// session_start();
include_once(__DIR__ . '/../includes/utils.php');
// if(isset($_SESSION["username"])) {
//     header("Location: /student_grade_management_system/dashboard");
//     exit();
// }


$adminRoles = ["Admin", "Professor"];
if (getSession("isLoggedIn") && in_array(getSession("roleName"), $adminRoles)) {
    header("Location: /student_grade_management_system/admin");
    exit();
}
