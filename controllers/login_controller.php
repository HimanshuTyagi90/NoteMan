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

// Validate inputs
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'NoteMan');

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Query to check if the user exists
$sql = "SELECT user_id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

// Check if prepare failed
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($userId, $dbPassword);
    $stmt->fetch();

    // Compare provided password with stored password
    if ($password === $dbPassword) {
        // Set session data for the logged-in user
        $_SESSION['user_id'] = $userId;

        // Respond with success and the user ID
        echo json_encode(['success' => true, 'userId' => $userId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No user found with this email']);
}

$stmt->close();
$conn->close();
?>
