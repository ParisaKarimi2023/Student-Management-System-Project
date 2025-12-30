<?php
include_once(__DIR__ . '/../includes/utils.php');

$adminRoles = ["Student"];
if (!getSession("isLoggedIn") || !in_array(getSession("roleName"), $adminRoles)) {
    header("Location: /student_grade_management_system/student/login.php");
    exit();
}
