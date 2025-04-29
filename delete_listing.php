<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

// Get car ID from request
$carId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($carId <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid car ID']);
    exit();
}

// Database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

$conn = new mysqli($server, $userid, $pw, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Verify the car belongs to the user
$username = $_SESSION['username'];

$sql = "SELECT Image FROM Cars WHERE CarID = $carId AND Username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Car not found or not authorized']);
    exit();
}

// Get the image path before deleting
$row = $result->fetch_assoc();
$imagePath = $row['Image'];

// Delete the car
$sql = "DELETE FROM Cars WHERE CarID = $carId AND Username = '$username'";

if ($conn->query($sql) === TRUE) {
    // Delete the image file if it exists
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete car']);
}

$conn->close();
?> 