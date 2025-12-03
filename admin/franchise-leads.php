<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $id = intval($_POST['lead_id']);
        $status = sanitize($_POST['status']);
        $notes = sanitize($_POST['admin_notes']);
        
        $stmt = $pdo->prepare("UPDATE franchise_inquiries SET status = ?, admin_notes = ? WHERE id = ?");
        $stmt->execute([$status, $notes, $id]);
        $success = 'Lead updated successfully!';
    }
    
    if (isset($_POST['delete_lead'])) {
        $id = intval($_POST['lead_id']);
        $stmt = $pdo->prepare("DELETE FROM franchise_inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Lead deleted successfully!';
    }
}

$leads = $pdo->query("SELECT * FROM franchise_inquiries ORDER BY created_at DESC")->fetchAll();
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Franchise Leads</h1>
        <p>Manage franchise inquiries</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($leads)): ?>
        <div class="empty-state">
            <i class="fas fa-handshake"></i>
            <h3>No franchise leads yet</h3>
            <p>Franchise inquiries will appear here</p>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Investment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($lead['name']); ?></strong></td>
                    <td>
                        <?php if ($lead['email']): ?>
                        <a href="mailto:<?php echo $lead['email']; ?>"><?php echo $lead['email']; ?></a><br>
                        <?php endif; ?>
                        <a href="tel:<?php echo $lead['phone']; ?>"><?php echo $lead['phone']; ?></a>
                    </td>
                    <td><?php echo htmlspecialchars($lead['city'] . ($lead['state'] ? ', ' . $lead['state'] : '')); ?></td>
                    <td><?php echo htmlspecialchars($lead['investment_capacity'] ?: 'Not specified'); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $lead['status'] === 'new' ? 'warning' : ($lead['status'] === 'contacted' ? 'info' : ($lead['status'] === 'converted' ? 'success' : 'danger')); ?>">
                            <?php echo ucfirst($lead['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($lead['created_at'])); ?></td>
                    <td>
                        <div class="actions">
                            <button class="action-btn edit" onclick="showDetail(<?php echo $lead['id']; ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                <button type="submit" name="delete_lead" class="action-btn delete delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr id="detail-<?php echo $lead['id']; ?>" style="display: none;">
                    <td colspan="7" style="background: var(--body-bg); padding: 20px;">
                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                            <div>
                                <h4 style="margin-bottom: 15px;">Lead Details</h4>
                                <p><strong>Experience:</strong><br><?php echo nl2br(htmlspecialchars($lead['experience'] ?: 'Not provided')); ?></p>
                                <p style="margin-top: 15px;"><strong>Message:</strong><br><?php echo nl2br(htmlspecialchars($lead['message'] ?: 'No additional message')); ?></p>
                            </div>
                            <div>
                                <form method="POST">
                                    <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="new" <?php echo $lead['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                            <option value="contacted" <?php echo $lead['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                            <option value="negotiating" <?php echo $lead['status'] === 'negotiating' ? 'selected' : ''; ?>>Negotiating</option>
                                            <option value="converted" <?php echo $lead['status'] === 'converted' ? 'selected' : ''; ?>>Converted</option>
                                            <option value="rejected" <?php echo $lead['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Admin Notes</label>
                                        <textarea name="admin_notes" class="form-control" rows="3"><?php echo $lead['admin_notes']; ?></textarea>
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
