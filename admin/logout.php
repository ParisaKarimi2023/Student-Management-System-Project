<?php
    session_start();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Login Page
        header("Location: /student_grade_management_system/admin/login.php");
    }
?>
