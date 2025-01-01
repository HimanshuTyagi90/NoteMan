<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'NoteMan');

// Check connection
if ($conn->connect_error) {
    die(json_encode(["message" => "Database connection failed: " . $conn->connect_error]));
}

// Start session and validate user
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Error: User is not logged in."]);
    exit;
}
$userId = $_SESSION['user_id'];

// Utility function to respond with JSON
function respond($data) {
    echo json_encode($data);
    exit;
}

// Folder creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createFolder'])) {
    $folderName = trim($_POST['folderName']);

    if (empty($folderName)) {
        respond(["message" => "Error: Folder name cannot be empty."]);
    }

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO folders (name, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $folderName, $userId);

    if ($stmt->execute()) {
        respond(["message" => "New folder created successfully."]);
    } else {
        respond(["message" => "Error: Unable to create folder."]);
    }

    $stmt->close();
}

// Folder search
if (isset($_GET['searchFolder'])) {
    $query = trim($_GET['searchFolder']);
    $stmt = $conn->prepare("SELECT * FROM folders WHERE name LIKE ? AND user_id = ?");
    $searchQuery = "%$query%";
    $stmt->bind_param("si", $searchQuery, $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $folders = $result->fetch_all(MYSQLI_ASSOC);
        respond($folders);
    } else {
        respond(["message" => "Error: Unable to search folders."]);
    }

    $stmt->close();
}

// Fetch folder structure
if (!isset($_GET['searchFolder'])) {
    $stmt = $conn->prepare("SELECT * FROM folders WHERE user_id = ? ORDER BY id");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $folders = $result->fetch_all(MYSQLI_ASSOC);
        respond($folders);
    } else {
        respond(["message" => "Error: Unable to fetch folder structure."]);
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>