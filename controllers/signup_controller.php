<?php

// Start the session to manage user data
    session_start();
// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Check if JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

// Extract form data
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
$firstName = $input['firstName'] ?? '';
$lastName = $input['lastName'] ?? '';
$phone = $input['phoneNo'] ?? '';

// Validate inputs
if (empty($email) || empty($password) || empty($firstName) || empty($lastName) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'NoteMan');

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Insert user data into the database (without hashing the password)
$sql = "INSERT INTO users (email, password, first_name, last_name, phone)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if prepare failed
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
    exit;
}

$stmt->bind_param('sssss', $email, $password, $firstName, $lastName, $phone);
$stmt->execute();

// Get the last inserted userId
$userId = $stmt->insert_id;

// Check if the insertion was successful
if ($userId) {
    echo json_encode(['success' => true, 'userId' => $userId]);
    $_SESSION['user_id'] = $userId;
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create account']);
}

$stmt->close();
$conn->close();
?>
