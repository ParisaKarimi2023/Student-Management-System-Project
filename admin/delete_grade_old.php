<?php 
// to show all php errors
include('../display_errors.php');
// include auth_session.php file on all user panel pages
include('../auth_session.php');
require('../db.php');

if(isset($_GET["studentId"])){
    $studentId = $_GET["studentId"];
    $query = "DELETE FROM students WHERE id=$studentId AND user_id=" . $_SESSION['userId'];
    mysqli_query($con, $query);
   
}
header("Location: /student_grade_management_system/dashboard");
exit;


?>