<?php
// Include database configuration
require_once __DIR__ . '../db_config.php';

try {
    // Define tables and their creation queries
    $tables = [
        "users" => "
            CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                phone VARCHAR(15),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        "folders" => "
            CREATE TABLE IF NOT EXISTS folders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                parent_folder_id INT DEFAULT NULL,  -- To create subfolders
                user_id INT NOT NULL,  -- Each folder is tied to a user
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (parent_folder_id) REFERENCES folders(id) ON DELETE CASCADE,  -- Self-referencing to handle subfolders
                FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Foreign key to users
            )
        ",
        "notes" => "
            CREATE TABLE IF NOT EXISTS notes (
                note_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                folder_id INT NOT NULL,  -- Reference to the folder where the note resides
                filename VARCHAR(255) NOT NULL,  -- Name of the file (note)
                file_size INT NOT NULL,  -- Size of the file in bytes
                file_type VARCHAR(50) NOT NULL,  -- Type of the file (PDF, DOCX, etc.)
                content TEXT,  -- For text-based notes
                uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
                FOREIGN KEY (folder_id) REFERENCES folders(id) ON DELETE CASCADE
            )
        "
    ];

    // Create each table if it doesn't exist
    foreach ($tables as $table => $sql) {
        $pdo->exec($sql);
        echo "Table '$table' checked and created if not present.<br>";
    }

    echo "Setup complete.";
} catch (PDOException $e) {
    die("Error during setup: " . $e->getMessage());
}
?>
