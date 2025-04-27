<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get car ID from request
$carId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($carId <= 0) {
    die(json_encode(['error' => 'Invalid car ID']));
}

// Fetch car details
$sql = "SELECT * FROM cars WHERE CarID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Car not found']);
}

$stmt->close();
$conn->close();
?> 