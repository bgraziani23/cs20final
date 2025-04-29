<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

$conn = new mysqli($server, $userid, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $carId = intval($_POST['carId']);
    $model = $_POST['model'];
    //ensure numbers from strings become values that can be used in sql
    $price = intval($_POST['price']);
    $miles = intval($_POST['miles']);
    // make state uppercase
    $state = strtoupper($_POST['state']);
    $city = $_POST['city'];
    $description = $_POST['description'];
    $username = $_SESSION['username'];

    // Verify the car belongs to the user
    $sql = "SELECT Image FROM Cars WHERE CarID = $carId AND Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        header("Location: dashboard.php");
        exit();
    }

    $currentImage = $result->fetch_assoc()['Image'];
    $imagePath = $currentImage;

    // Handle image upload if a new image was provided
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $target_dir = "images/";
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image_filename = "images/car_" . $carId . "." . $file_extension;
        $target_file = $target_dir . $image_filename;
        
        // Check if image file is valid
        $valid_types = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($file_extension, $valid_types)) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if it exists
            if (file_exists($currentImage)) {
                unlink($currentImage);
            }
            $imagePath = $image_filename;
        }
    }

    // Update the car listing
    $sql = "UPDATE Cars SET 
            Model = '$model',
            Price = $price,
            Miles = $miles,
            State = '$state',
            City = '$city',
            Description = '$description',
            Image = '$imagePath'
            WHERE CarID = $carId AND Username = '$username'";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?> 