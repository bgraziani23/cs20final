<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "umegccruvfeiy", "thisisapass", "dbimljtmuxm7qy");

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM Users WHERE Username = '$username'");

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['Password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['profilepic'] = $row['profilepic'];
            header("Location: dashboard.php");
        } else {
            header("Location: login.html?error=invalid_password");
        }
    } else {
        header("Location: login.html?error=user_not_found");
    }
    exit();
}

$conn->close();
?>
