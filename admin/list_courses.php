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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Of Courses</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
</head>

<body>
    <div class="header">
        <div class="menu">
            <strong><?= $_SESSION['roleName'] . ": " . $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            <a class="link-primary" href="/student_grade_management_system/admin/logout.php">Logout</a>
        </div>
    </div>

    <div class="main">
        <div class="left-side-bar">
            <div>
                <ul>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_professors.php">List Of Professors</a></li>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_courses.php">List Of Courses</a></li>
                    <li><a href="http://localhost/student_grade_management_system/admin/list_students.php">List Of Students</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="table-container">
                <h2>List Of Courses</h2>
                <a class="link-primary" href="/student_grade_management_system/admin/add_course.php">New Course</a>

                <div style="margin-top: 0.5em;">

                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Professor</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $query    = "SELECT courses.*, CONCAT(users.first_name, ' ', users.last_name) as professor FROM courses " .
                            "INNER JOIN users ON courses.professor_id=users.id " .
                            "WHERE courses.deleted=0";
                        $result = mysqli_query($con, $query) or die(mysqli_error($con));
                        if ($result) {
                            while ($course =  mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= $course["title"] ?></td>
                                    <td><?= $course["professor"] ?></td>
                                    <td><?= date('Y-m-d', strtotime($course["created_at"])) ?></td>
                                    <td>
                                        <a class="link-primary" href="<?= '/student_grade_management_system/admin/edit_course.php?courseId=' . $course['id'] ?>">Edit</a>
                                        <a class="link-danger" href="<?= '/student_grade_management_system/admin/delete_course.php?courseId=' . $course['id'] ?>">Delete</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }

                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="copy-right">
            @Copyright <a href="http://localhost/student_grade_management_system/admin/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>

</body>

</html>