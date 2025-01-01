<?php
$searchTerm = $_GET['searchTerm'] ?? '';

$conn = new mysqli('localhost', 'root', '', 'NoteMan');
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM folders WHERE name LIKE '%$searchTerm%'";
$result = $conn->query($sql);
$folders = [];
while ($row = $result->fetch_assoc()) {
    $folders[] = $row;
}

echo json_encode($folders);
$conn->close();
?>
