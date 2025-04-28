<?php
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

// Create a new MySQLi connection
$conn = new mysqli($server, $userid, $pw, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8
$conn->set_charset("utf8");

// Get car ID from request
$carId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($carId <= 0) {
    die(json_encode(['error' => 'Invalid car ID']));
}

// Prepare the SQL query
$sql = "SELECT * FROM Cars WHERE CarID = $carId";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the car data
$car = null;

// Fetch the data
if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
}

// Close the connection
$conn->close();

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode($car ?: ['error' => 'Car not found']);
?> 