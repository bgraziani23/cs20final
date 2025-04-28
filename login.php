<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

// database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

$conn = new mysqli($server, $userid, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['Password'])) {
        
            $_SESSION['username'] = $username;
            $_SESSION['profilepic'] = $row['profilepic'];

            
            header("Location: dashboard.php");
            exit();
        } else {
           
            header("Location: login.html?error=invalid_password");
            exit();
        }
    } else {
        // User not found
        header("Location: login.html?error=user_not_found");
        exit();
    }
}

$conn->close();
?>
