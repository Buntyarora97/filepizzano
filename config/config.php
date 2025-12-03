<?php
session_start();

// Error handling configuration
// Set to false in production to prevent information leakage
$isProduction = getenv('REPLIT_DEPLOYMENT') === '1';
if ($isProduction) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

define('SITE_NAME', 'Pizzano');
define('SITE_TAGLINE', 'Café | Bakery | Restaurant');
define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);
define('ADMIN_EMAIL', 'info@pizzano.in');

define('BRANCH_BATHINDA', [
    'name' => 'Pizzano Bathinda',
    'address' => 'The Mall Road, Bathinda',
    'phone' => '+91 82880-93880',
    'hours' => '11:00 AM - 11:00 PM',
    'map_link' => 'https://maps.google.com/?q=Pizzano+Mall+Road+Bathinda'
]);

define('BRANCH_DABWALI', [
    'name' => 'Pizzano Dabwali',
    'address' => 'Colony Road, Mandi Dabwali, Near PNB Bank',
    'phone' => '+91 98968-45577',
    'hours' => '11:00 AM - 11:00 PM',
    'map_link' => 'https://maps.google.com/?q=Pizzano+Colony+Road+Mandi+Dabwali'
]);

define('SOCIAL_LINKS', [
    'facebook' => 'https://facebook.com/pizzano',
    'instagram' => 'https://instagram.com/pizzano',
    'youtube' => 'https://youtube.com/pizzano',
    'twitter' => 'https://twitter.com/pizzano'
]);

require_once __DIR__ . '/database.php';

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $current_page = basename($_SERVER['PHP_SELF']);
        if ($current_page !== 'login.php') {
            header('Location: /admin/login.php');
            exit;
        }
    }
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
