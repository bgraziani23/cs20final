<?php
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

// Get car ID from request
if (isset($_GET['id'])) {
    $carId = intval($_GET['id']);
} else {
    $carId = 0;
}


// get the car with the ID needed
$sql = "SELECT * FROM Cars WHERE CarID = $carId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
}

$conn->close();

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode($car);
?> 