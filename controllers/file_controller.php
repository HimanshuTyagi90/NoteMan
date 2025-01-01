<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'NoteMan');

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Handle file upload
if (isset($_POST['uploadFile'])) {
    $folderId = $_POST['folderId']; // Get the folder ID from POST
    $file = $_FILES['fileUpload'];
    $targetDir = "uploads/";

    // Validate folder ID
    if (!is_numeric($folderId) || $folderId <= 0) {
        echo json_encode(["error" => "Invalid folder ID."]);
        exit;
    }

    // File type validation (allow only PDF, DOCX, etc.)
    $allowedTypes = ['pdf', 'docx', 'txt'];
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(["error" => "Error: Unsupported file type."]);
        exit;
    }

    // File size validation (max 10MB)
    if ($file['size'] > 10485760) {
        echo json_encode(["error" => "Error: File size exceeds the limit."]);
        exit;
    }

    $targetFile = $targetDir . basename($file['name']);

    // Sanitize file name
    $targetFile = $targetDir . mysqli_real_escape_string($conn, basename($file['name']));

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        $sql = "INSERT INTO files (folder_id, filename) VALUES ($folderId, '$targetFile')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => "File uploaded successfully."]);
        } else {
            echo json_encode(["error" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Error: File upload failed."]);
    }
}

// Handle file download
if (isset($_GET['downloadFile'])) {
    $fileId = $_GET['fileId'];
    $sql = "SELECT * FROM files WHERE id = $fileId";
    $result = $conn->query($sql);
    $file = $result->fetch_assoc();

    if ($file) {
        $filePath = $file['filename'];
        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            readfile($filePath);
        } else {
            echo json_encode(["error" => "Error: File does not exist on the server."]);
        }
    } else {
        echo json_encode(["error" => "Error: File not found."]);
    }
}

// Handle file deletion
if (isset($_POST['deleteFile'])) {
    $fileId = $_POST['fileId'];
    $sql = "SELECT * FROM files WHERE id = $fileId";
    $result = $conn->query($sql);
    $file = $result->fetch_assoc();

    if ($file) {
        $filePath = $file['filename'];

        // Delete the file from the server
        if (unlink($filePath)) {
            $sql = "DELETE FROM files WHERE id = $fileId";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["success" => "File deleted successfully."]);
            } else {
                echo json_encode(["error" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Error: Could not delete file from server."]);
        }
    } else {
        echo json_encode(["error" => "Error: File not found."]);
    }
}

// Handle fetching files for a specific folder
if (isset($_GET['folderId'])) {
    $folderId = $_GET['folderId'];
    
    // Validate folderId to prevent invalid input
    if (!is_numeric($folderId) || $folderId <= 0) {
        echo json_encode(["error" => "Invalid folder ID."]);
        exit;
    }

    $sql = "SELECT * FROM files WHERE folder_id = $folderId";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $files = [];
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
        echo json_encode($files);
    } else {
        echo json_encode(["error" => "No files found for this folder."]);
    }
}

$conn->close();
?>
