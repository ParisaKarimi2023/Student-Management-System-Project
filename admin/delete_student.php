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

if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    $updatedAt = date("Y-m-d H:i:s");
    try {
        mysqli_begin_transaction($con);
        $userQuery = "UPDATE users " .
            "SET deleted=1, updated_at='$updatedAt' " .
            "WHERE id=$userId";
        mysqli_query($con, $userQuery);

        $studentQuery = "UPDATE students " .
            "SET deleted=1, updated_at='$updatedAt' " .
            "WHERE user_id=$userId";
        mysqli_query($con, $studentQuery);


        mysqli_commit($con);
    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($con);
    }
}
header("Location: /student_grade_management_system/admin/list_students.php");
exit;
