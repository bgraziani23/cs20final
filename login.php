<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // start a PHP session

// Database connection settings
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

    // !!!!! Replace 'your_table_name' with your actual table name
    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['Password'])) {
            // Password is correct
            $_SESSION['username'] = $username;
            $_SESSION['profilepic'] = $row['profilepic']; // save profile pic path

            echo "Login successful!<br>";
            echo "<img src='" . $row['profilepic'] . "' width='100'><br>";
            echo "Welcome, " . htmlspecialchars($username) . "!";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
