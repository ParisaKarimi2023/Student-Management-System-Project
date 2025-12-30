<?php 
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/student_auth_guard.php');
if (!in_array(getSession("roleName"), ["Student"])) {
    header("Location: /student_grade_management_system/common/403.php");
    exit;
}
require_once(__DIR__ . '/../includes/db.php');

if(isset($_GET["selectedCourseId"])){
    
    $selectedCourseId = $_GET["selectedCourseId"];
    $updatedAt = date("Y-m-d H:i:s");
    $query = "UPDATE course_student " .
            "SET deleted=1, updated_at='$updatedAt' " .
            "WHERE id=$selectedCourseId";
    mysqli_query($con, $query);
   
}

header("Location: /student_grade_management_system/student/my_selected_courses.php");
exit;


?>