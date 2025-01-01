<?php
// Database Configuration File: db_config.php

// Database connection details
$host = 'localhost';
$dbName = 'NoteMan';
$username = 'root';
$password = '';
$port = 3306;

try {
    // Create a connection to the server (without specifying the database)
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database exists
    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['dbname' => $dbName]);

    if ($stmt->rowCount() == 0) {
        // Create the database if it doesn't exist
        $pdo->exec("CREATE DATABASE $dbName");
        echo "Database '$dbName' created successfully.<br>";
    }

    // Connect to the database
    $pdo->exec("USE $dbName");
    echo "Connected to the database '$dbName'.<br>";
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
