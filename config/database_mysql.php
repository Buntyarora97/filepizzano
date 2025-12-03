
<?php
// Hostinger MySQL Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name'); // cPanel से मिलेगा
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

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
