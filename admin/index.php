<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/admin_auth_guard.php');
// require_once(__DIR__ . '/../includes/db.php');
if (in_array(getSession("roleName"), ["Admin"])) {
    // include_once(__DIR__ . "/list_professors.php");
    header("Location: /student_grade_management_system/admin/list_professors.php");
    exit;
} elseif (in_array(getSession("roleName"), ["Professor"])) {
    // include_once(__DIR__ . "/list_grades.php");
    header("Location: /student_grade_management_system/admin/list_grades.php");
    exit;
}
?>
