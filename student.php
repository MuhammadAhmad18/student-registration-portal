<?php
session_start();
include "DB.php";

// check if logged in and role is student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.html");
    exit();
}

// get student details from DB
$student_id = $_SESSION['user_id'];
$sql = "SELECT name, roll_number, subject FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <style>
    body { margin:0; font-family:"Segoe UI", Tahoma; background:#eef2f7; padding:40px; }
    .card { background:white; padding:25px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.1); max-width:600px; margin:auto; }
    h2 { color:#4a47a3; text-align:center; margin-bottom:20px; }
    ul { list-style:none; padding:0; }
    li { padding:10px; margin:8px 0; background:#f5f5f5; border-radius:6px; }
    .logout { display:block; margin-top:20px; text-align:center; }
    .logout a { color:#fff; background:#4a47a3; padding:10px 20px; border-radius:6px; text-decoration:none; }
    .logout a:hover { background:#37348c; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Welcome, <?php echo $student['name']; ?></h2>
    <p><strong>Roll Number:</strong> <?php echo htmlspecialchars($student['roll_number']); ?></p>
    <h3>My Subjects</h3>
    <ul>
      <li><?php echo htmlspecialchars($student['subject']); ?> - Next Class: Monday 10 AM</li>
    </ul>
    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>