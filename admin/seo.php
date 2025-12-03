<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_seo'])) {
        $id = intval($_POST['seo_id']);
        $meta_title = sanitize($_POST['meta_title']);
        $meta_description = sanitize($_POST['meta_description']);
        $meta_keywords = sanitize($_POST['meta_keywords']);
        
        $stmt = $pdo->prepare("UPDATE seo_pages SET meta_title = ?, meta_description = ?, meta_keywords = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$meta_title, $meta_description, $meta_keywords, $id]);
        $success = 'SEO settings updated successfully!';
    }
}

$seoPages = $pdo->query("SELECT * FROM seo_pages ORDER BY page_slug")->fetchAll();
?>

<div class="top-bar">
    <div class="page-title">
        <h1>SEO Manager</h1>
        <p>Manage page meta tags and SEO settings</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>Page SEO Settings</h2>
    </div>
    <div class="card-body">
        <?php if (empty($seoPages)): ?>
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>No SEO pages configured</h3>
            <p>SEO settings will be added automatically</p>
        </div>
        <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($seoPages as $page): ?>
            <form method="POST" style="background: var(--body-bg); border-radius: 12px; padding: 25px; border: 1px solid var(--border-color);">
                <input type="hidden" name="seo_id" value="<?php echo $page['id']; ?>">
                
                <h3 style="margin-bottom: 20px; color: var(--primary);">
                    <i class="fas fa-file"></i> <?php echo ucfirst($page['page_slug']); ?> Page
                </h3>
                
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($page['meta_title']); ?>" maxlength="70">
                    <small style="color: var(--text-muted);">Recommended: 50-60 characters</small>
                </div>
                
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3" maxlength="160"><?php echo htmlspecialchars($page['meta_description']); ?></textarea>
                    <small style="color: var(--text-muted);">Recommended: 150-160 characters</small>
                </div>
                
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" value="<?php echo htmlspecialchars($page['meta_keywords']); ?>">
                    <small style="color: var(--text-muted);">Comma-separated keywords</small>
                </div>
                
                <button type="submit" name="update_seo" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Update SEO
                </button>
            </form>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
