<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['teacher_login'])) {
        if ($_POST['password'] === 'teacher123') {
            $_SESSION['role'] = 'teacher';
            header("Location: teacher.php");
            exit;
        } else {
            $error = "Wrong teacher password.";
        }
    }
    if (isset($_POST['student_login'])) {
        $name = mysqli_real_escape_string($conn, trim($_POST['student_name']));
        $res = mysqli_query($conn, "SELECT * FROM student WHERE name='$name'");
        if ($res && mysqli_num_rows($res) > 0) {
            $s = mysqli_fetch_assoc($res);
            $_SESSION['role'] = 'student';
            $_SESSION['student_id'] = $s['id'];
            $_SESSION['student_name'] = $s['name'];
            header("Location: student.php");
            exit;
        } else {
            $error = "Student not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SSMS Login</title>
<style>
body { font-family: sans-serif; margin: 2rem; }
.box { margin-bottom: 2rem; padding: 1rem; border: 1px solid #ccc; max-width: 300px; }
</style>
</head>
<body>
<center>
<h1>Student Schedule Management</h1>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

<div class="box">
  <h3>Teacher Login</h3>
  <form method="POST">
    <p>Password (teacher123): <input type="password" name="password" required></p>
    <button type="submit" name="teacher_login">Login</button>
  </form>
</div>

<div class="box">
  <h3>Student Login</h3>
  <form method="POST">
    <p>Your Name: <input type="text" name="student_name" required></p>
    <button type="submit" name="student_login">Login</button>
  </form>
</div>
</center>
</body>
</html>
