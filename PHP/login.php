<?php
session_start();

// Dummy credentials for demonstration
$valid_username = 'admin';
$valid_password = 'admin';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        // Set session or cookie as needed
        $_SESSION['loggedin'] = true;
        header('Location: ../HTML/home.html');
        exit();
    } else {
        header('Location: ../index.html');
        echo "<script>alert('Invalid username or password.');</script>";
        exit();
    }
}
?>
