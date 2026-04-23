<?php
session_start();
if ($_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit;
}
require 'db.php';

// Add student
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $query = "INSERT INTO student (name,course,year) VALUES ('$name','$course','$year')";
    mysqli_query($conn, $query);
}

// Update student
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $query = "UPDATE student SET name='$name', course='$course', year='$year' WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Del student
if (isset($_GET['del_student'])) {
    $id = $_GET['del_student'];
    $query = "DELETE FROM student WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Add schedule
if (isset($_POST['add_schedule'])) {
    $sid = $_POST['student_id'];
    $date = $_POST['date'];
    $query = "INSERT INTO schedule (student_id,date) VALUES ('$sid','$date')";
    mysqli_query($conn, $query);
}

// Update schedule
if (isset($_POST['update_schedule'])) {
    $id = $_POST['id'];
    $sid = $_POST['student_id'];
    $date = $_POST['date'];
    $query = "UPDATE schedule SET student_id='$sid', date='$date' WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Del schedule
if (isset($_GET['del_schedule'])) {
    $id = $_GET['del_schedule'];
    $query = "DELETE FROM schedule WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Add activity
if (isset($_POST['add_activity'])) {
    $scid = $_POST['schedule_id'];
    $task = $_POST['task'];
    $cat = $_POST['category'];
    $st = $_POST['start_time'];
    $en = $_POST['end_time'];
    $query = "INSERT INTO activity (schedule_id,task,category,start_time,end_time) VALUES ('$scid','$task','$cat','$st','$en')";
    mysqli_query($conn, $query);
}

// Update activity
if (isset($_POST['update_activity'])) {
    $id = $_POST['id'];
    $scid = $_POST['schedule_id'];
    $task = $_POST['task'];
    $cat = $_POST['category'];
    $st = $_POST['start_time'];
    $en = $_POST['end_time'];
    $query = "UPDATE activity SET schedule_id='$scid', task='$task', category='$cat', start_time='$st', end_time='$en' WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Del activity
if (isset($_GET['del_activity'])) {
    $id = $_GET['del_activity'];
    $query = "DELETE FROM activity WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Get data for tables
$q_students = "SELECT * FROM student";
$students = mysqli_query($conn, $q_students);

$q_schedules = "SELECT schedule.*, student.name FROM schedule JOIN student ON schedule.student_id=student.id";
$schedules = mysqli_query($conn, $q_schedules);

$q_activities = "SELECT activity.*, schedule.date, student.name FROM activity JOIN schedule ON activity.schedule_id=schedule.id JOIN student ON schedule.student_id=student.id";
$activities = mysqli_query($conn, $q_activities);
?>

<p><a href="index.php?logout=1">Logout</a></p>
<center>
<h2>Teacher Dashboard</h2>

<!-- STUDENTS SECTION -->
<div style="border: 1px solid black; padding: 20px; width: 800px; margin-bottom: 20px;">
  <h3>1. Students</h3>
  
  <?php 
  $edit_st_id = ''; $edit_st_name = ''; $edit_st_course = ''; $edit_st_year = '';
  if (isset($_GET['edit_student'])) {
      $es_id = $_GET['edit_student'];
      $es_res = mysqli_query($conn, "SELECT * FROM student WHERE id='$es_id'");
      if ($es_row = mysqli_fetch_assoc($es_res)) {
          $edit_st_id = $es_row['id'];
          $edit_st_name = $es_row['name'];
          $edit_st_course = $es_row['course'];
          $edit_st_year = $es_row['year'];
      }
  }
  ?>
  
  <form method="POST">
    <?php if ($edit_st_id != '') { ?>
      <input type="hidden" name="id" value="<?php echo $edit_st_id; ?>">
      Name: <input type="text" name="name" value="<?php echo $edit_st_name; ?>">
      Course: <input type="text" name="course" value="<?php echo $edit_st_course; ?>">
      Year: <input type="text" name="year" value="<?php echo $edit_st_year; ?>">
      <button type="submit" name="update_student">Update</button>
      <a href="teacher.php">Cancel</a>
    <?php } else { ?>
      Name: <input type="text" name="name">
      Course: <input type="text" name="course">
      Year: <input type="text" name="year">
      <button type="submit" name="add_student">Add</button>
    <?php } ?>
  </form>
  <br>
  
  <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <tr><th>ID</th><th>Name</th><th>Course</th><th>Year</th><th>Action</th></tr>
    <?php while($s = mysqli_fetch_assoc($students)) { ?>
    <tr>
      <td><?php echo $s['id']; ?></td>
      <td><?php echo $s['name']; ?></td>
      <td><?php echo $s['course']; ?></td>
      <td><?php echo $s['year']; ?></td>
      <td>
        <a href="?edit_student=<?php echo $s['id']; ?>">Edit</a> | 
        <a href="?del_student=<?php echo $s['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>

<!-- SCHEDULES SECTION -->
<div style="border: 1px solid black; padding: 20px; width: 800px; margin-bottom: 20px;">
  <h3>2. Schedules</h3>
  
  <?php 
  $edit_sc_id = ''; $edit_sc_sid = ''; $edit_sc_date = '';
  if (isset($_GET['edit_schedule'])) {
      $esc_id = $_GET['edit_schedule'];
      $esc_res = mysqli_query($conn, "SELECT * FROM schedule WHERE id='$esc_id'");
      if ($esc_row = mysqli_fetch_assoc($esc_res)) {
          $edit_sc_id = $esc_row['id'];
          $edit_sc_sid = $esc_row['student_id'];
          $edit_sc_date = $esc_row['date'];
      }
  }
  ?>
  
  <form method="POST">
    <?php if ($edit_sc_id != '') { ?>
      <input type="hidden" name="id" value="<?php echo $edit_sc_id; ?>">
      Student: 
      <select name="student_id">
        <?php 
        $students_list1 = mysqli_query($conn, "SELECT * FROM student");
        while($st = mysqli_fetch_assoc($students_list1)) { ?>
          <option value="<?php echo $st['id']; ?>" <?php if($st['id'] == $edit_sc_sid) echo "selected"; ?>>
            <?php echo $st['name']; ?>
          </option>
        <?php } ?>
      </select>
      Date: <input type="date" name="date" value="<?php echo $edit_sc_date; ?>">
      <button type="submit" name="update_schedule">Update</button>
      <a href="teacher.php">Cancel</a>
    <?php } else { ?>
      Student: 
      <select name="student_id">
        <?php 
        $students_list2 = mysqli_query($conn, "SELECT * FROM student");
        while($st = mysqli_fetch_assoc($students_list2)) { ?>
          <option value="<?php echo $st['id']; ?>"><?php echo $st['name']; ?></option>
        <?php } ?>
      </select>
      Date: <input type="date" name="date">
      <button type="submit" name="add_schedule">Add</button>
    <?php } ?>
  </form>
  <br>
  
  <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <tr><th>ID</th><th>Student</th><th>Date</th><th>Action</th></tr>
    <?php while($sc = mysqli_fetch_assoc($schedules)) { ?>
    <tr>
      <td><?php echo $sc['id']; ?></td>
      <td><?php echo $sc['name']; ?></td>
      <td><?php echo $sc['date']; ?></td>
      <td>
        <a href="?edit_schedule=<?php echo $sc['id']; ?>">Edit</a> | 
        <a href="?del_schedule=<?php echo $sc['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>

<!-- TASKS SECTION -->
<div style="border: 1px solid black; padding: 20px; width: 800px; margin-bottom: 20px;">
  <h3>3. Tasks</h3>
  
  <?php 
  $edit_ac_id = ''; $edit_ac_scid = ''; $edit_ac_task = ''; 
  $edit_ac_cat = ''; $edit_ac_st = ''; $edit_ac_en = '';
  if (isset($_GET['edit_activity'])) {
      $eac_id = $_GET['edit_activity'];
      $eac_res = mysqli_query($conn, "SELECT * FROM activity WHERE id='$eac_id'");
      if ($eac_row = mysqli_fetch_assoc($eac_res)) {
          $edit_ac_id = $eac_row['id'];
          $edit_ac_scid = $eac_row['schedule_id'];
          $edit_ac_task = $eac_row['task'];
          $edit_ac_cat = $eac_row['category'];
          $edit_ac_st = $eac_row['start_time'];
          $edit_ac_en = $eac_row['end_time'];
      }
  }
  ?>
  
  <form method="POST">
    <?php if ($edit_ac_id != '') { ?>
      <input type="hidden" name="id" value="<?php echo $edit_ac_id; ?>">
      Schedule ID:
      <select name="schedule_id">
        <?php 
        $sc_list1 = mysqli_query($conn, "SELECT schedule.*, student.name FROM schedule JOIN student ON schedule.student_id=student.id");
        while($scl = mysqli_fetch_assoc($sc_list1)) { ?>
          <option value="<?php echo $scl['id']; ?>" <?php if($scl['id'] == $edit_ac_scid) echo "selected"; ?>>
            <?php echo $scl['name']; ?> (<?php echo $scl['date']; ?>)
          </option>
        <?php } ?>
      </select>
      <br><br>
      Task: <input type="text" name="task" value="<?php echo $edit_ac_task; ?>">
      Category: <input type="text" name="category" value="<?php echo $edit_ac_cat; ?>">
      Start: <input type="time" name="start_time" value="<?php echo $edit_ac_st; ?>">
      End: <input type="time" name="end_time" value="<?php echo $edit_ac_en; ?>">
      <button type="submit" name="update_activity">Update</button>
      <a href="teacher.php">Cancel</a>
    <?php } else { ?>
      Schedule ID:
      <select name="schedule_id">
        <?php 
        $sc_list2 = mysqli_query($conn, "SELECT schedule.*, student.name FROM schedule JOIN student ON schedule.student_id=student.id");
        while($scl = mysqli_fetch_assoc($sc_list2)) { ?>
          <option value="<?php echo $scl['id']; ?>"><?php echo $scl['name']; ?> (<?php echo $scl['date']; ?>)</option>
        <?php } ?>
      </select>
      <br><br>
      Task: <input type="text" name="task">
      Category: <input type="text" name="category">
      Start: <input type="time" name="start_time">
      End: <input type="time" name="end_time">
      <button type="submit" name="add_activity">Add</button>
    <?php } ?>
  </form>
  <br>
  
  <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <tr><th>ID</th><th>Student</th><th>Date</th><th>Task</th><th>Category</th><th>Times</th><th>Action</th></tr>
    <?php while($a = mysqli_fetch_assoc($activities)) { ?>
    <tr>
      <td><?php echo $a['id']; ?></td>
      <td><?php echo $a['name']; ?></td>
      <td><?php echo $a['date']; ?></td>
      <td><?php echo $a['task']; ?></td>
      <td><?php echo $a['category']; ?></td>
      <td><?php echo $a['start_time']; ?> - <?php echo $a['end_time']; ?></td>
      <td>
        <a href="?edit_activity=<?php echo $a['id']; ?>">Edit</a> | 
        <a href="?del_activity=<?php echo $a['id']; ?>">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
</center>
