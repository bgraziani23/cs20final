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

// Prepare the SQL query
$sql = "SELECT CarID, Model, Price, Miles, State, City, Image, Description, Username FROM Cars";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the car data
$cars = array();

// Fetch the data
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}

// Close the connection
$conn->close();

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode($cars);
?>
