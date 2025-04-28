<?php
// Start the session to access username
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the current highest CarID
    $result = $conn->query("SELECT MAX(CarID) as maxID FROM Cars");
    $row = $result->fetch_assoc();
    $newCarID = $row['maxID'] + 1;

    // Get form data
    $model = $conn->real_escape_string($_POST['model']);
    $price = floatval($_POST['price']);
    $miles = intval($_POST['miles']);
    $state = $conn->real_escape_string(strtoupper($_POST['state']));
    $city = $conn->real_escape_string($_POST['city']);
    $description = $conn->real_escape_string($_POST['description']);
    $username = $_SESSION['username'];
    
    // Handle image upload
    $target_dir = "images/";
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $image_filename = "images/car_" . $newCarID . "." . $file_extension;
    $target_file = $target_dir . $image_filename;
    
    // Check if image file is valid
    $valid_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_extension, $valid_types)) {
        die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
    }
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert data into database
        $sql = "INSERT INTO Cars (CarID, Model, Price, Miles, State, City, Image, Description, Username) 
                VALUES ($newCarID, '$model', $price, $miles, '$state', '$city', '$image_filename', '$description', '$username')";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to shop page after successful insertion
            header("Location: shop.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>