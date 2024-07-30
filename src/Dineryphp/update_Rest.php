<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust this based on your needs
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = ""; // add your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get data from POST request
$input = json_decode(file_get_contents('php://input'), true);

$id = isset($input['id']) ? $input['id'] : null;
$name = isset($input['name']) ? $input['name'] : null;
$address = isset($input['address']) ? $input['address'] : null;
$rating = isset($input['rating']) ? $input['rating'] : null;

if ($id === null || $name === null || $address === null || $rating === null) {
    echo json_encode(["error" => "Missing required parameters"]);
    http_response_code(400);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE restaurants SET name=?, address=?, rating=? WHERE id=?");
$stmt->bind_param("ssii", $name, $address, $rating, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Error updating record: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
