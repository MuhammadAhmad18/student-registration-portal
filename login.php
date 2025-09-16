<?php
session_start();
include "DB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] === 'admin') {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: student.php");
            exit();
        }
    } else {
        echo "<script>alert('Incorrect email or password'); window.location='login.html';</script>";
        exit();
    }
}
?>