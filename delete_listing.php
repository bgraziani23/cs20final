<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Not logged in'
    ]);
    exit();
}

// Get car ID from request
$carId = 0;
if (isset($_GET['id'])) {
    $carId = intval($_GET['id']);
}

// Database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

$conn = new mysqli($server, $userid, $pw, $db);

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed'
    ]);
    exit();
}

// check if the car belongs to the user
$username = $_SESSION['username'];

$sql = "SELECT Image FROM Cars WHERE CarID = $carId AND Username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'error' => 'Car not found'
    ]);
    exit();
}

// get image before we delete it so we can clear some space
$row = $result->fetch_assoc();
$imagePath = $row['Image'];

// Delete the car
$sql = "DELETE FROM Cars WHERE CarID = $carId AND Username = '$username'";

if ($conn->query($sql) === TRUE) {
    // delete image if it exists (sometimes null image in our db)
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    echo json_encode([
        'success' => true
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to delete car'
    ]);
}

$conn->close();
?> 