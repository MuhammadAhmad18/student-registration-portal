<?php
include "DB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $father_name = $_POST['father'];
    $roll_number = $_POST['roll'];
    $subject = $_POST['subject'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = md5($_POST['password']); // hash password

    $sql = "INSERT INTO users (name, father_name, roll_number, subject, phone, email, gender, password, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'student')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $father_name, $roll_number, $subject, $phone, $email, $gender, $password);

    if ($stmt->execute()) {
        // Success message and redirect after 3 seconds
        echo "
        <script>
            alert('Account created successfully! You will be redirected to login page.');
            setTimeout(function() {
                window.location.href = 'login.html';
            }, 3000);
        </script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
        exit();
    }
}
?>