<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}
require 'db.php';

$sid = $_SESSION['student_id'];

// Get student
$query1 = "SELECT * FROM student WHERE id='$sid'";
$sres = mysqli_query($conn, $query1);
$me = mysqli_fetch_assoc($sres);

// Get schedules
$query2 = "SELECT * FROM schedule WHERE student_id='$sid' ORDER BY date DESC";
$scheds = mysqli_query($conn, $query2);
?>

<p><a href="index.php?logout=1">Logout</a></p>
<center>
<h2>Welcome, <?php echo $me['name']; ?> (<?php echo $me['course']; ?>)</h2>

<?php if (mysqli_num_rows($scheds) == 0) { ?>
  <p>No schedules assigned yet.</p>
<?php } else { ?>
  
  <?php while ($sc = mysqli_fetch_assoc($scheds)) { 
    $scid = $sc['id'];
    $query3 = "SELECT * FROM activity WHERE schedule_id='$scid' ORDER BY start_time";
    $acts = mysqli_query($conn, $query3);
  ?>
    <div style="margin-bottom: 20px;">
      <h3>Date: <?php echo $sc['date']; ?></h3>
      
      <?php if (mysqli_num_rows($acts) == 0) { ?>
        <p>No tasks.</p>
      <?php } else { ?>
        <table border="1" cellpadding="10" style="border-collapse: collapse;">
          <tr>
            <th>Task</th>
            <th>Category</th>
            <th>Time</th>
          </tr>
          <?php while($a = mysqli_fetch_assoc($acts)) { ?>
          <tr>
            <td><?php echo $a['task']; ?></td>
            <td><?php echo $a['category']; ?></td>
            <td><?php echo $a['start_time']; ?> - <?php echo $a['end_time']; ?></td>
          </tr>
          <?php } ?>
        </table>
      <?php } ?>
    </div>
  <?php } ?>
<?php } ?>
</center>
