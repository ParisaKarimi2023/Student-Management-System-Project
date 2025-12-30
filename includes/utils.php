<?php

// function test_input($data) {
//     $data = trim($data);
//     $data = stripslashes($data);
//     $data = htmlspecialchars($data);
//     return $data;
//   }

function loadBaseSession($data)
{
  $sessionData = [
    "userId" => $data["id"],
    "firstName" => $data["first_name"],
    "lastName" => $data["last_name"],
    "username" => $data["email"],
    "email" => $data["email"],
    "roleName" => $data["role_name"],
    "isLoggedIn" => true

  ];
  setSession($sessionData);
}

function setSession($array = [])
{
  startSession();
  if ($array) {
    foreach ($array as $key => $value) {
      $_SESSION[$key] = $value;
    }
  }
}

function getSession($key)
{
  startSession();
  if (isset($_SESSION[$key])) {
    return $_SESSION[$key];
  }
  return null;
}

function startSession()
{
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

function getRoleId($roleName, $con)
{
  // require_once(__DIR__ . '/includes/db.php');
  $query = "SELECT id FROM roles WHERE name='$roleName'";
  $result = mysqli_query($con, $query);
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
  }
  return false;
}

function getProfessors($con)
{
  $roleId = getRoleId("Professor", $con);
  $query = "SELECT * FROM users WHERE role_id=$roleId AND deleted=0";
  $result = mysqli_query($con, $query);
  if ($result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  return false;
}

// function getCourses($stu$con)
// {
//   $query = "SELECT * FROM courses WHERE id NOT IN (SELECT course_id FROM course_student WHERE student_id=) deleted=0";
//   $result = mysqli_query($con, $query);
//   if ($result) {
//     return mysqli_fetch_all($result, MYSQLI_ASSOC);
//   }
//   return false;
// }

function getStudentId($userId, $con)
{
  $query = "SELECT id FROM students WHERE user_id=$userId AND  deleted=0";
  $result = mysqli_query($con, $query);
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
  }
  return false;
}

function getNotSelectedCoursesByStudent($studentId, $con)
{
  $query = "SELECT * FROM courses WHERE id NOT IN (SELECT course_id FROM course_student WHERE student_id=$studentId AND deleted=0) AND deleted=0";
  $result = mysqli_query($con, $query);
  if ($result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  return false;
}

function courseAlreadyDeleted($studentId, $courseId, $con)
{
  $query = "SELECT * FROM course_student WHERE course_id=$courseId AND student_id=$studentId";
  $result = mysqli_query($con, $query);
  // if($result){
  $rows = mysqli_num_rows($result);
  if ($rows == 1) {
    return true;
  }
  return false;
}
