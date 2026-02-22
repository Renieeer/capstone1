<?php

// Database connection settings - update $dbname to your database name
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'guidance_tbl'; // <-- set your DB name
$charset  = 'utf8mb4';

$dsn = "mysql:host=$hostname;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $connection = new PDO($dsn, $username, $password, $options);
  
} catch (PDOException $e) {
    // Return JSON on connection failure (useful for AJAX callers) and stop execution
    echo json_encode(["success" => false, "message" => "Connection failed: " . $e->getMessage()]);
    exit;
}

// $connection and $conn will be used by other scripts that include this file
?>