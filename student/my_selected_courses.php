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
$studentId = getStudentId(getSession("userId"), $con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Selected Courses</title>
    <link rel="stylesheet" href="/student_grade_management_system/assets/css/common/main.css">
</head>

<body>
    <div class="header">
        <div class="menu">
            <strong><?= $_SESSION['roleName'] . ": " . $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            <a class="link-primary" href="/student_grade_management_system/student/logout.php">Logout</a>
        </div>
    </div>

    <div class="main">
        <div class="left-side-bar">
            <div>
                <ul>
                    <li><a href="http://localhost/student_grade_management_system/student/my_selected_courses.php">My Selected Courses</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="table-container">
                <h2>My Selected Courses</h2>
                <a class="link-primary" href="/student_grade_management_system/student/select_course.php">Select Course</a>

                <div style="margin-top: 0.5em;">

                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Professor</th>
                            <th>Grade</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        // $query    = "SELECT courses.*, CONCAT(users.first_name, ' ', users.last_name) as professor FROM courses " .
                        //     "INNER JOIN users ON courses.professor_id=users.id " .
                        //     "WHERE courses.deleted=0 AND courses.id IN (SELECT course_id FROM course_student WHERE student_id=$studentId AND deleted=0)";




                        $query    = "SELECT courses.title, CONCAT(users.first_name, ' ', users.last_name) as professor, course_student.*, grade_appeal.id as grade_appeal_id FROM course_student " .
                            "INNER JOIN courses ON course_student.course_id=courses.id " .
                            "INNER JOIN users ON courses.professor_id=users.id " .
                            "LEFT JOIN grade_appeal ON course_student.id=grade_appeal.course_student_id " .
                            "WHERE course_student.student_id=$studentId AND course_student.deleted=0 ";
                        // "WHERE courses.deleted=0 AND courses.id IN (SELECT course_id FROM course_student WHERE student_id=$studentId AND deleted=0)";



                        $result = mysqli_query($con, $query) or die(mysqli_error($con));
                        // echo '<pre>';
                        // print_r(mysqli_fetch_all($result, MYSQLI_ASSOC));die;
                        if ($result) {
                            while ($selectedCourse =  mysqli_fetch_assoc($result)) {
                        ?>
                                <td><?= $selectedCourse["title"] ?></td>
                                <td><?= $selectedCourse["professor"] ?></td>
                                <td><?= $selectedCourse["grade"] ?></td>
                                <td><?= date('Y-m-d', strtotime($selectedCourse["created_at"])) ?></td>
                                <td style="display: flex;align-items: center;">
                                    <a style="margin-right: 0.5em;" class="link-primary" href="<?= '/student_grade_management_system/student/delete_selected_course.php?selectedCourseId=' . $selectedCourse['id'] ?>" title="Delete Course"><img src="/student_grade_management_system/assets/images/delete.png" alt="Delete Course" width="23" height="25"></a>
                                    <?php if (!$selectedCourse["grade_appeal_id"]) { ?>
                                        <a class="link-primary" href="<?= '/student_grade_management_system/student/submit_grade_appeal.php?selectedCourseId=' . $selectedCourse['id'] ?>">Submit Grade Appeal</a>
                                    <?php } else { ?>
                                        <a class="link-primary" href="<?= '/student_grade_management_system/student/view_grade_appeal.php?gradeAppealId=' . $selectedCourse['grade_appeal_id'] ?>">View Your Grade Appeal</a>
                                    <?php } ?>
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
            @Copyright <a href="http://localhost/student_grade_management_system/student/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>

</body>

</html>