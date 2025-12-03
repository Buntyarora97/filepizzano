<?php
function getConnection() {
    static $pdo = null;
    
    if ($pdo !== null) {
        return $pdo;
    }
    
    // Check if MySQL credentials are available in environment
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASSWORD');
    
    // Try MySQL if environment variables are set
    if ($db_host && $db_name && $db_user && $db_pass) {
        try {
            // MySQL connection (Hostinger)
            $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
            $pdo = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $pdo;
        } catch (PDOException $e) {
            // MySQL failed, fall through to SQLite
            error_log("MySQL connection failed: " . $e->getMessage() . " - Falling back to SQLite");
        }
    }
    
    // SQLite fallback for local development or if MySQL fails
    try {
        $db_path = __DIR__ . '/../database/pizzano.db';
        
        if (!file_exists(dirname($db_path))) {
            mkdir(dirname($db_path), 0755, true);
        }
        
        $pdo = new PDO('sqlite:' . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        if (!file_exists($db_path) || filesize($db_path) == 0) {
            initDatabase($pdo);
        }
        
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function initDatabase($pdo) {
    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schema);
    
    $seed = file_get_contents(__DIR__ . '/../database/seed.sql');
    if ($seed) {
        $pdo->exec($seed);
    }
}
?>
