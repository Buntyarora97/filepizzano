<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();

$productCount = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories WHERE status = 1")->fetchColumn();
$contactCount = $pdo->query("SELECT COUNT(*) FROM contact_inquiries WHERE status = 'new'")->fetchColumn();
$franchiseCount = $pdo->query("SELECT COUNT(*) FROM franchise_inquiries WHERE status = 'new'")->fetchColumn();

$recentContacts = $pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recentFranchise = $pdo->query("SELECT * FROM franchise_inquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Dashboard</h1>
        <p>Welcome back, <?php echo $_SESSION['admin_name'] ?? 'Admin'; ?>!</p>
    </div>
    <div class="user-menu">
        <div class="user-info">
            <span><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
            <small>Super Admin</small>
        </div>
        <div class="user-avatar">
            <?php echo strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)); ?>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-pizza-slice"></i>
        </div>
        <h3><?php echo $productCount; ?></h3>
        <p>Total Products</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h3><?php echo $categoryCount; ?></h3>
        <p>Categories</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <h3><?php echo $contactCount; ?></h3>
        <p>New Inquiries</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-handshake"></i>
        </div>
        <h3><?php echo $franchiseCount; ?></h3>
        <p>Franchise Leads</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
    <div class="card">
        <div class="card-header">
            <h2>Recent Contact Inquiries</h2>
            <a href="/admin/inquiries.php" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (empty($recentContacts)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No inquiries yet</h3>
                <p>Contact inquiries will appear here</p>
            </div>
            <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentContacts as $contact): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                        <td><?php echo htmlspecialchars($contact['subject'] ?: 'General'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $contact['status'] === 'new' ? 'warning' : 'success'; ?>">
                                <?php echo ucfirst($contact['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2>Recent Franchise Leads</h2>
            <a href="/admin/franchise-leads.php" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (empty($recentFranchise)): ?>
            <div class="empty-state">
                <i class="fas fa-handshake"></i>
                <h3>No leads yet</h3>
                <p>Franchise leads will appear here</p>
            </div>
            <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentFranchise as $lead): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lead['name']); ?></td>
                        <td><?php echo htmlspecialchars($lead['city'] ?: 'N/A'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $lead['status'] === 'new' ? 'warning' : 'success'; ?>">
                                <?php echo ucfirst($lead['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($lead['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 25px;">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    <div class="card-body">
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="/admin/products.php?action=add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
            <a href="/admin/categories.php?action=add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
            <a href="/admin/banners.php?action=add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Banner
            </a>
            <a href="/admin/gallery.php?action=add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Gallery Image
            </a>
            <a href="/" target="_blank" class="btn btn-secondary">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
