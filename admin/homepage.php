<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_section'])) {
        $id = intval($_POST['section_id']);
        $title = sanitize($_POST['title']);
        $subtitle = sanitize($_POST['subtitle']);
        $content = sanitize($_POST['content']);
        $image = sanitize($_POST['image']);
        $status = isset($_POST['status']) ? 1 : 0;
        
        $stmt = $pdo->prepare("UPDATE homepage_sections SET title = ?, subtitle = ?, content = ?, image = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$title, $subtitle, $content, $image, $status, $id]);
        $success = 'Section updated successfully!';
    }
}

$sections = $pdo->query("SELECT * FROM homepage_sections ORDER BY sort_order")->fetchAll();
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Homepage Sections</h1>
        <p>Manage all homepage content</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>Edit Homepage Sections</h2>
    </div>
    <div class="card-body">
        <?php if (empty($sections)): ?>
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>No sections configured</h3>
            <p>Run the seed data to populate sections</p>
        </div>
        <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 25px;">
            <?php foreach ($sections as $section): ?>
            <form method="POST" style="background: var(--body-bg); border-radius: 12px; padding: 25px; border: 1px solid var(--border-color);">
                <input type="hidden" name="section_id" value="<?php echo $section['id']; ?>">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="color: var(--primary);">
                        <i class="fas fa-file-alt"></i> <?php echo ucwords(str_replace('_', ' ', $section['section_key'])); ?> Section
                    </h3>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="status" <?php echo $section['status'] ? 'checked' : ''; ?>> Active
                    </label>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($section['title'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($section['image'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Subtitle / Description</label>
                    <textarea name="subtitle" class="form-control" rows="2"><?php echo htmlspecialchars($section['subtitle'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Additional Content (HTML allowed)</label>
                    <textarea name="content" class="form-control" rows="3"><?php echo htmlspecialchars($section['content'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" name="update_section" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Update Section
                </button>
            </form>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
