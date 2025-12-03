<?php
// =====================================================
// HOSTINGER MYSQL CONFIGURATION
// =====================================================
// INSTRUCTIONS:
// 1. Delete or rename the current database.php
// 2. Rename this file to database.php
// 3. Update the credentials below with YOUR Hostinger database details
// =====================================================

// UPDATE THESE WITH YOUR HOSTINGER DATABASE CREDENTIALS
define('DB_HOST', 'localhost');
define('DB_NAME', 'u872449974_pizzano');      // e.g., u872449974_pizzano
define('DB_USER', 'u872449974_pizzano');      // e.g., u872449974_pizzano
define('DB_PASS', 'Pizzano@0001');  // Your MySQL password

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function getConnection() {
    global $pdo;
    return $pdo;
}
?>
