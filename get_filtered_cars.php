<?php
header('Content-Type: application/json');

// Database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

// Create connection
$conn = new mysqli($server, $userid, $pw, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Build the SQL query
$sql = "SELECT CarID, Model, Price, Miles, State, City, Image, Description, Username FROM Cars";

// Add filters based on preferences
if (!empty($_GET['minPrice'])) {
    $minPrice = intval($_GET['minPrice']);
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE Price >= $minPrice";
    } else {
        $sql .= " AND Price >= $minPrice";
    }
}

if (!empty($_GET['maxPrice'])) {
    $maxPrice = intval($_GET['maxPrice']);
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE Price <= $maxPrice";
    } else {
        $sql .= " AND Price <= $maxPrice";
    }
}

if (!empty($_GET['minMileage'])) {
    $minMileage = intval($_GET['minMileage']);
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE Miles >= $minMileage";
    } else {
        $sql .= " AND Miles >= $minMileage";
    }
}

if (!empty($_GET['maxMileage'])) {
    $maxMileage = intval($_GET['maxMileage']);
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE Miles <= $maxMileage";
    } else {
        $sql .= " AND Miles <= $maxMileage";
    }
}

if (!empty($_GET['state'])) {
    $state = $conn->real_escape_string($_GET['state']);
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE State = '$state'";
    } else {
        $sql .= " AND State = '$state'";
    }
}

$sql .= " ORDER BY CarID DESC";

// Execute the query
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

$conn->close();
echo json_encode($cars);
?> 