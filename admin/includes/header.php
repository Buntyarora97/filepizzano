<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';

if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
    requireLogin();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Admin Panel - Pizzano</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #E85A1E;
            --primary-dark: #C44A15;
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
            --body-bg: #0f0f1a;
            --card-bg: #1a1a2e;
            --text-light: #ffffff;
            --text-muted: #a0a0a0;
            --border-color: #2a2a4a;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #3498db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--body-bg);
            color: var(--text-light);
            min-height: 100vh;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 25px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo img {
            height: 50px;
        }

        .sidebar-logo span {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            padding: 10px 20px;
            font-size: 11px;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 1px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background: var(--sidebar-hover);
            border-left-color: var(--primary);
        }

        .nav-item i {
            width: 35px;
            font-size: 18px;
            color: var(--text-muted);
        }

        .nav-item:hover i,
        .nav-item.active i {
            color: var(--primary);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-info span {
            display: block;
            font-weight: 500;
        }

        .user-info small {
            color: var(--text-muted);
            font-size: 12px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(232, 90, 30, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .card-body {
            padding: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--border-color);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
        }

        .table tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(243, 156, 18, 0.2);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }

        .badge-info {
            background: rgba(52, 152, 219, 0.2);
            color: var(--info);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-light);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--body-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(232, 90, 30, 0.2);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .product-thumb {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .action-btn.edit {
            background: rgba(52, 152, 219, 0.2);
            color: var(--info);
        }

        .action-btn.delete {
            background: rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 60px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php if (isLoggedIn()): ?>
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="/assets/images/logo.png" alt="Pizzano">
                <span>Admin Panel</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">Main</div>
                <a href="/admin/" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>

                <div class="nav-section">Catalog</div>
                <a href="/admin/products.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>">
                    <i class="fas fa-pizza-slice"></i> Products
                </a>
                <a href="/admin/categories.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i> Categories
                </a>

                <div class="nav-section">Content</div>
                <a href="/admin/homepage.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'homepage.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Homepage
                </a>
                <a href="/admin/banners.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'banners.php' ? 'active' : ''; ?>">
                    <i class="fas fa-images"></i> Banners
                </a>
                <a href="/admin/gallery.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'gallery.php' ? 'active' : ''; ?>">
                    <i class="fas fa-photo-video"></i> Gallery
                </a>
                <a href="/admin/testimonials.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'testimonials.php' ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i> Testimonials
                </a>

                <div class="nav-section">Leads</div>
                <a href="/admin/inquiries.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'inquiries.php' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i> Contact Inquiries
                </a>
                <a href="/admin/franchise-leads.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'franchise-leads.php' ? 'active' : ''; ?>">
                    <i class="fas fa-handshake"></i> Franchise Leads
                </a>

                <div class="nav-section">Settings</div>
                <a href="/admin/branches.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'branches.php' ? 'active' : ''; ?>">
                    <i class="fas fa-store"></i> Branches
                </a>
                <a href="/admin/seo.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'seo.php' ? 'active' : ''; ?>">
                    <i class="fas fa-search"></i> SEO Manager
                </a>
                <a href="/admin/logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        <?php endif; ?>

        <main class="main-content">