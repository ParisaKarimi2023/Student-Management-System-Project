<?php
// to show all php errors
include_once(__DIR__ . '/../includes/display_errors.php');
include_once(__DIR__ . '/../includes/utils.php');
// include admin_auth_guard.php file on all admin panel pages
include_once(__DIR__ . '/../filters/admin_auth_guard.php');

if (!in_array(getSession("roleName"), ["Professor"])) {
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
    <title>List Of Grades</title>
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
                    <li><a href="http://localhost/student_grade_management_system/admin/list_grades.php">List Of Grades</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div class="table-container">
                <h2>List Of Grades</h2>
                <div style="margin-top: 0.5em;">

                    <table>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Grade</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $query    = "SELECT courses.title as course, CONCAT(users.first_name, ' ', users.last_name) as student, grade_appeal.id as grade_appeal_id, grade_appeal.read_by_professor, course_student.* FROM course_student " .
                            "INNER JOIN courses ON course_student.course_id=courses.id " .
                            "INNER JOIN students ON course_student.student_id=students.id " .
                            "INNER JOIN users ON students.user_id=users.id " .
                            "LEFT JOIN grade_appeal ON course_student.id=grade_appeal.course_student_id " .
                            "WHERE course_student.deleted=0 AND courses.professor_id=" . getSession("userId");
                        $result = mysqli_query($con, $query) or die(mysqli_error($con));
                        // echo '<pre>';
                        // print_r(mysqli_fetch_all($result, MYSQLI_ASSOC));
                        // die;
                        if ($result) {
                            while ($grade =  mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= $grade["student"] ?></td>
                                    <td><?= $grade["course"] ?></td>
                                    <td><?= $grade["grade"] ?></td>
                                    <td><?= date('Y-m-d', strtotime($grade["created_at"])) ?></td>
                                    <td><?= date('Y-m-d', strtotime($grade["updated_at"])) ?></td>
                                    <td style="display: flex; align-items: center;">
                                        <a style="margin-right: 0.5em;" class="link-primary" href="<?= '/student_grade_management_system/admin/edit_grade.php?gradeId=' . $grade['id'] ?>">Edit</a>
                                        <?php if ($grade["grade_appeal_id"]) { ?>
                                            <?php if (!$grade["read_by_professor"]) { ?>
                                                <a class="link-primary" href="<?= '/student_grade_management_system/admin/read_grade_appeal.php?gradeAppealId=' . $grade['grade_appeal_id'] ?>" title="read Grade Appeal"><img src="/student_grade_management_system/assets/images/new_message.png" alt="read Grade Appeal" width="30" height="25"></a>
                                            <?php } else { ?>
                                                <a class="link-primary" href="<?= '/student_grade_management_system/admin/read_grade_appeal.php?gradeAppealId=' . $grade['grade_appeal_id'] ?>" title="read Grade Appeal"><img src="/student_grade_management_system/assets/images/old_message.png" alt="read Grade Appeal" width="30" height="25"></a>
                                            <?php } ?>
                                        <?php } else { ?>

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
            @Copyright <a href="http://localhost/student_grade_management_system/admin/"> Student Grade Management System </a> <?= date("Y") ?>- All Right Reserved.
        </div>
    </footer>

</body>

</html>