<?php
require 'DB.php';
session_start();

$email = $_POST['username'] ?? '';
$pass  = $_POST['password'] ?? '';

// keep the same hashing your app uses so existing users still match
$pass_hash = md5($pass);

// VULNERABLE ON PURPOSE: user input is concatenated directly into SQL
$sql = "SELECT id, name, email FROM users WHERE email = '$email' AND password = '$pass_hash'";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    header('Location: student.php');
    exit;
} else {
    echo "Login failed";
}