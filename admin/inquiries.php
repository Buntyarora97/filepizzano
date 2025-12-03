<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $id = intval($_POST['inquiry_id']);
        $status = sanitize($_POST['status']);
        $notes = sanitize($_POST['admin_notes']);
        
        $stmt = $pdo->prepare("UPDATE contact_inquiries SET status = ?, admin_notes = ? WHERE id = ?");
        $stmt->execute([$status, $notes, $id]);
        $success = 'Inquiry updated successfully!';
    }
    
    if (isset($_POST['delete_inquiry'])) {
        $id = intval($_POST['inquiry_id']);
        $stmt = $pdo->prepare("DELETE FROM contact_inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Inquiry deleted successfully!';
    }
}

$inquiries = $pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC")->fetchAll();
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Contact Inquiries</h1>
        <p>Manage customer inquiries</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($inquiries)): ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No inquiries yet</h3>
            <p>Customer inquiries will appear here</p>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inquiries as $inquiry): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($inquiry['name']); ?></strong></td>
                    <td>
                        <?php if ($inquiry['email']): ?>
                        <a href="mailto:<?php echo $inquiry['email']; ?>"><?php echo $inquiry['email']; ?></a><br>
                        <?php endif; ?>
                        <?php if ($inquiry['phone']): ?>
                        <a href="tel:<?php echo $inquiry['phone']; ?>"><?php echo $inquiry['phone']; ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($inquiry['subject'] ?: 'General'); ?></td>
                    <td style="max-width: 250px;"><?php echo htmlspecialchars(substr($inquiry['message'], 0, 100)); ?>...</td>
                    <td>
                        <span class="badge badge-<?php echo $inquiry['status'] === 'new' ? 'warning' : ($inquiry['status'] === 'resolved' ? 'success' : 'info'); ?>">
                            <?php echo ucfirst($inquiry['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y H:i', strtotime($inquiry['created_at'])); ?></td>
                    <td>
                        <div class="actions">
                            <button class="action-btn edit" onclick="showDetail(<?php echo $inquiry['id']; ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                <button type="submit" name="delete_inquiry" class="action-btn delete delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr id="detail-<?php echo $inquiry['id']; ?>" style="display: none;">
                    <td colspan="7" style="background: var(--body-bg); padding: 20px;">
                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                            <div>
                                <h4 style="margin-bottom: 10px;">Full Message</h4>
                                <p style="color: var(--text-muted); line-height: 1.8;"><?php echo nl2br(htmlspecialchars($inquiry['message'])); ?></p>
                            </div>
                            <div>
                                <form method="POST">
                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="new" <?php echo $inquiry['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                            <option value="in_progress" <?php echo $inquiry['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="resolved" <?php echo $inquiry['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Notes</label>
                                        <textarea name="admin_notes" class="form-control" rows="3"><?php echo $inquiry['admin_notes']; ?></textarea>
                                    </div>
                                    <button type="submit" name="update_status" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
function showDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
