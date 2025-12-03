<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_branch'])) {
        $id = intval($_POST['branch_id']);
        $name = sanitize($_POST['name']);
        $address = sanitize($_POST['address']);
        $city = sanitize($_POST['city']);
        $phone = sanitize($_POST['phone']);
        $email = sanitize($_POST['email']);
        $hours = sanitize($_POST['opening_hours']);
        $map_link = sanitize($_POST['map_link']);
        $status = isset($_POST['status']) ? 1 : 0;
        
        $stmt = $pdo->prepare("UPDATE branches SET name = ?, address = ?, city = ?, phone = ?, email = ?, hours = ?, opening_hours = ?, map_link = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $address, $city, $phone, $email, $hours, $hours, $map_link, $status, $id]);
        $success = 'Branch updated successfully!';
    }
}

$branches = $pdo->query("SELECT * FROM branches ORDER BY sort_order")->fetchAll();

$editBranch = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM branches WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editBranch = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Branch Management</h1>
        <p>Manage restaurant locations</p>
    </div>
    <?php if ($action !== 'list'): ?>
    <a href="/admin/branches.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<?php if ($action === 'edit' && $editBranch): ?>
<div class="card">
    <div class="card-header">
        <h2>Edit Branch</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <input type="hidden" name="branch_id" value="<?php echo $editBranch['id']; ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label>Branch Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo $editBranch['name']; ?>">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $editBranch['city']; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label>Full Address</label>
                <textarea name="address" class="form-control" rows="2"><?php echo $editBranch['address']; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $editBranch['phone']; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $editBranch['email']; ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Opening Hours</label>
                    <input type="text" name="opening_hours" class="form-control" placeholder="e.g., 11:00 AM - 11:00 PM" value="<?php echo $editBranch['hours'] ?? $editBranch['opening_hours']; ?>">
                </div>
                <div class="form-group">
                    <label>Google Maps Link</label>
                    <input type="text" name="map_link" class="form-control" value="<?php echo $editBranch['map_link']; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" <?php echo $editBranch['status'] ? 'checked' : ''; ?>> Active
                </label>
            </div>
            
            <button type="submit" name="edit_branch" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Branch
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($branches as $branch): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($branch['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($branch['address']); ?></td>
                    <td>
                        <a href="tel:<?php echo $branch['phone']; ?>"><?php echo $branch['phone']; ?></a>
                    </td>
                    <td><?php echo $branch['hours'] ?? $branch['opening_hours']; ?></td>
                    <td>
                        <span class="badge badge-<?php echo $branch['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $branch['status'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="?action=edit&id=<?php echo $branch['id']; ?>" class="action-btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
