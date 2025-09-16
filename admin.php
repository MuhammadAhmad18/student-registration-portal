<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include "DB.php";

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Handle student deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}

// Fetch all students
$sql = "SELECT id, roll_number, name, subject FROM users WHERE role='student'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { margin:0; font-family:"Segoe UI", Tahoma; background:#eef2f7; padding:40px; }
    .card { background:white; padding:25px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.1); max-width:800px; margin:auto; }
    h2 { color:#4a47a3; text-align:center; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:12px; border-bottom:1px solid #ddd; text-align:center; }
    th { background:#4a47a3; color:white; }
    button { background:red; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; }
    button:hover { background:darkred; }
    a.logout {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #fff;
      background: #4a47a3;
      padding: 10px;
      text-decoration: none;
      border-radius: 8px;
    }
    a.logout:hover { background: #37348c; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Admin Dashboard</h2>
    <table>
      <tr><th>Roll No</th><th>Name</th><th>Subject</th><th>Action</th></tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['roll_number']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td>
              <form method="POST" action="admin.php" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">No students found</td></tr>
      <?php endif; ?>
    </table>

    <a href="logout.php" class="logout">Logout</a>
  </div>
</body>
</html>