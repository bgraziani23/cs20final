<?php
// Database connection settings
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

// Create connection
$conn = new mysqli($server, $userid, $pw, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash the password

    // Handle profile picture upload
    $target_dir = "uploads/"; // Make sure this folder exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // create uploads/ folder if it doesn't exist
    }

    $profile_pic_name = basename($_FILES["profile_pic"]["name"]);
    $unique_name = uniqid() . "_" . $profile_pic_name; // make filename unique
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Insert new user into database
        $sql = "INSERT INTO Users (Username, Email, Password, profilepic) 
                VALUES ('$username', '$email', '$password', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            // If account created successfully
            echo "<script>
                    alert('Account created successfully!');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        } else {
            // Database error
            echo "<script>
                    alert('Error creating account. Please try again.');
                    window.location.href = 'signup.html';
                  </script>";
            exit();
        }
    } else {
        // File upload failed
        echo "<script>
                alert('Error uploading profile picture. Please try again.');
                window.location.href = 'signup.html';
              </script>";
        exit();
    }
}

// Close connection
$conn->close();
?>
