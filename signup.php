<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "umegccruvfeiy", "thisisapass", "dbimljtmuxm7qy");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $target_dir = "uploads/";
    $profile_pic_name = basename($_FILES["profile_pic"]["name"]);
    $unique_name = uniqid() . "_" . $profile_pic_name;
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO Users (Username, Email, Password, profilepic) 
                      VALUES ('$username', '$email', '$password', '$target_file')");

        echo "<script>
                alert('Account created successfully!');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo "<script>
                alert('Error uploading profile picture. Please try again.');
                window.location.href = 'signup.html';
              </script>";
    }
    exit();
}

$conn->close();
?>
