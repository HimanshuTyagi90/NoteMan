<?php
session_start(); // Start the session
session_destroy(); // Destroy the session
header("Location: ../views/index.php"); // Redirect to login page
exit();
?>