<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_testimonial']) || isset($_POST['edit_testimonial'])) {
        $name = sanitize($_POST['name']);
        $designation = sanitize($_POST['designation']);
        $content = sanitize($_POST['content']);
        $rating = intval($_POST['rating']);
        $status = isset($_POST['status']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if (isset($_POST['add_testimonial'])) {
            $stmt = $pdo->prepare("INSERT INTO testimonials (name, designation, content, rating, status, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $content, $rating, $status, $sort_order]);
            $success = 'Testimonial added successfully!';
        } else {
            $id = intval($_POST['testimonial_id']);
            $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, designation = ?, content = ?, rating = ?, status = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$name, $designation, $content, $rating, $status, $sort_order, $id]);
            $success = 'Testimonial updated successfully!';
        }
    }
    
    if (isset($_POST['delete_testimonial'])) {
        $id = intval($_POST['testimonial_id']);
        $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Testimonial deleted successfully!';
    }
}

$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY sort_order")->fetchAll();

$editTestimonial = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editTestimonial = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Testimonials</h1>
        <p>Manage customer reviews</p>
    </div>
    <?php if ($action === 'list'): ?>
    <a href="?action=add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Testimonial
    </a>
    <?php else: ?>
    <a href="/admin/testimonials.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="card">
    <div class="card-header">
        <h2><?php echo $action === 'add' ? 'Add New Testimonial' : 'Edit Testimonial'; ?></h2>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php if ($editTestimonial): ?>
            <input type="hidden" name="testimonial_id" value="<?php echo $editTestimonial['id']; ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Customer Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo $editTestimonial['name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g., Food Blogger, Regular Customer" value="<?php echo $editTestimonial['designation'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label>Review Content *</label>
                <textarea name="content" class="form-control" rows="4" required><?php echo $editTestimonial['content'] ?? ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Rating (1-5)</label>
                    <select name="rating" class="form-control">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo $i; ?>" <?php echo ($editTestimonial['rating'] ?? 5) == $i ? 'selected' : ''; ?>><?php echo $i; ?> Stars</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo $editTestimonial['sort_order'] ?? 0; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" <?php echo ($editTestimonial['status'] ?? true) ? 'checked' : ''; ?>> Active
                </label>
            </div>
            
            <button type="submit" name="<?php echo $action === 'add' ? 'add_testimonial' : 'edit_testimonial'; ?>" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $action === 'add' ? 'Add Testimonial' : 'Update Testimonial'; ?>
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <?php if (empty($testimonials)): ?>
        <div class="empty-state">
            <i class="fas fa-star"></i>
            <h3>No testimonials yet</h3>
            <p>Start by adding customer reviews</p>
            <a href="?action=add" class="btn btn-primary">Add First Testimonial</a>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Review</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $testimonial): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($testimonial['name']); ?></strong>
                        <div style="font-size: 12px; color: var(--text-muted);"><?php echo htmlspecialchars($testimonial['designation']); ?></div>
                    </td>
                    <td style="max-width: 300px;"><?php echo htmlspecialchars(substr($testimonial['content'], 0, 100)); ?>...</td>
                    <td>
                        <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                        <i class="fas fa-star" style="color: #f39c12;"></i>
                        <?php endfor; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo $testimonial['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $testimonial['status'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="?action=edit&id=<?php echo $testimonial['id']; ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                                <button type="submit" name="delete_testimonial" class="action-btn delete delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
