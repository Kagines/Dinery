<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once './config.php';

function get_input_data()
{
    return json_decode(file_get_contents('php://input'), true);
}

// Connect to the database
$conn = getDbConnection();

// Parse the request URL to determine the resource and ID
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$path = trim($request_uri[0], '/');
$segments = explode('/', $path);
$resource = $segments[1] ?? null;
$id = $segments[2] ?? null;

// Fetch all users
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'user' && !$id) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
    exit;
}

// Fetch a specific user
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'user' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "User not found"]);
    }
    exit;
}

// Fetch restaurants added by a specific user
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'user' && $id && isset($segments[3]) && $segments[3] == 'restaurants') {
    $id = intval($id);
    $sql = "SELECT * FROM restaurants WHERE user_id = $id";
    $result = $conn->query($sql);
    $restaurants = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $restaurants[] = $row;
        }
    }
    echo json_encode($restaurants);
    exit;
}

// Create a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'user') {
    $input = get_input_data();
    if (!$input) {
        echo json_encode(["message" => "Invalid input"]);
        http_response_code(400);
        exit;
    }

    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $password = password_hash($conn->real_escape_string($input['password']), PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

// Update a user
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'user' && $id) {
    $input = get_input_data();
    if (!$input) {
        echo json_encode(["message" => "Invalid input"]);
        http_response_code(400);
        exit;
    }

    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $password = password_hash($conn->real_escape_string($input['password']), PASSWORD_BCRYPT);

    $id = intval($id);
    $sql = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

// Delete a user
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'user' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

// Create a new restaurant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'restaurant') {
    $input = get_input_data();
    if (!$input) {
        echo json_encode(["message" => "Invalid input"]);
        http_response_code(400);
        exit;
    }

    $user_id = intval($input['user_id']);
    $name = $conn->real_escape_string($input['name']);
    $address = $conn->real_escape_string($input['address']);
    $rating = $conn->real_escape_string($input['rating']);

    $sql = "INSERT INTO restaurants (user_id, name, address, rating) VALUES ('$user_id', '$name', '$address', '$rating')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Restaurant created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

// Update a restaurant
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'restaurant' && $id) {
    $input = get_input_data();
    if (!$input) {
        echo json_encode(["message" => "Invalid input"]);
        http_response_code(400);
        exit;
    }

    $name = $conn->real_escape_string($input['name']);
    $address = $conn->real_escape_string($input['address']);
    $rating = $conn->real_escape_string($input['rating']);

    $id = intval($id);
    $sql = "UPDATE restaurants SET name = '$name', address = '$address', rating = '$rating' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Restaurant updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

// Delete a restaurant
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'restaurant' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM restaurants WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Restaurant deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
        http_response_code(500);
    }
    exit;
}

echo json_encode(["message" => "Invalid request method"]);
http_response_code(405);
$conn->close();
