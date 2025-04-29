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

// Initialize the WHERE conditions array
$conditions = [];
$params = [];
$types = '';

// Add filters based on preferences
if (!empty($_GET['minPrice'])) {
    $conditions[] = "Price >= ?";
    $params[] = intval($_GET['minPrice']);
    $types .= 'i';
}

if (!empty($_GET['maxPrice'])) {
    $conditions[] = "Price <= ?";
    $params[] = intval($_GET['maxPrice']);
    $types .= 'i';
}

if (!empty($_GET['minMileage'])) {
    $conditions[] = "Miles >= ?";
    $params[] = intval($_GET['minMileage']);
    $types .= 'i';
}

if (!empty($_GET['maxMileage'])) {
    $conditions[] = "Miles <= ?";
    $params[] = intval($_GET['maxMileage']);
    $types .= 'i';
}

if (!empty($_GET['state'])) {
    $conditions[] = "State = ?";
    $params[] = $_GET['state'];
    $types .= 's';
}

// Build the SQL query
$sql = "SELECT CarID, Model, Price, Miles, State, City, Image, Description, Username FROM Cars";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY CarID DESC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['error' => 'Prepare failed: ' . $conn->error]));
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    die(json_encode(['error' => 'Execute failed: ' . $stmt->error]));
}

$result = $stmt->get_result();
$cars = [];

while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($cars);
?> 