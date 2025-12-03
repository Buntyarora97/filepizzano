<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_banner']) || isset($_POST['edit_banner'])) {
        $title = sanitize($_POST['title']);
        $subtitle = sanitize($_POST['subtitle']);
        $button_text = sanitize($_POST['button_text']);
        $button_link = sanitize($_POST['button_link']);
        $image = sanitize($_POST['image']);
        $position = sanitize($_POST['position']);
        $status = isset($_POST['status']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if (isset($_POST['add_banner'])) {
            $stmt = $pdo->prepare("INSERT INTO banners (title, subtitle, button_text, button_link, image, position, status, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $subtitle, $button_text, $button_link, $image, $position, $status, $sort_order]);
            $success = 'Banner added successfully!';
        } else {
            $id = intval($_POST['banner_id']);
            $stmt = $pdo->prepare("UPDATE banners SET title = ?, subtitle = ?, button_text = ?, button_link = ?, image = ?, position = ?, status = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$title, $subtitle, $button_text, $button_link, $image, $position, $status, $sort_order, $id]);
            $success = 'Banner updated successfully!';
        }
    }
    
    if (isset($_POST['delete_banner'])) {
        $id = intval($_POST['banner_id']);
        $stmt = $pdo->prepare("DELETE FROM banners WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Banner deleted successfully!';
    }
}

$banners = $pdo->query("SELECT * FROM banners ORDER BY position, sort_order")->fetchAll();

$editBanner = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM banners WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editBanner = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Banners</h1>
        <p>Manage website banners</p>
    </div>
    <?php if ($action === 'list'): ?>
    <a href="?action=add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Banner
    </a>
    <?php else: ?>
    <a href="/admin/banners.php" class="btn btn-secondary">
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
        <h2><?php echo $action === 'add' ? 'Add New Banner' : 'Edit Banner'; ?></h2>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php if ($editBanner): ?>
            <input type="hidden" name="banner_id" value="<?php echo $editBanner['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label>Banner Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $editBanner['title'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Subtitle</label>
                <textarea name="subtitle" class="form-control" rows="2"><?php echo $editBanner['subtitle'] ?? ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="<?php echo $editBanner['button_text'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="<?php echo $editBanner['button_link'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image" class="form-control" value="<?php echo $editBanner['image'] ?? ''; ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Position</label>
                    <select name="position" class="form-control">
                        <option value="hero" <?php echo ($editBanner['position'] ?? '') === 'hero' ? 'selected' : ''; ?>>Hero Section</option>
                        <option value="promo" <?php echo ($editBanner['position'] ?? '') === 'promo' ? 'selected' : ''; ?>>Promo Banner</option>
                        <option value="popup" <?php echo ($editBanner['position'] ?? '') === 'popup' ? 'selected' : ''; ?>>Popup</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo $editBanner['sort_order'] ?? 0; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" <?php echo ($editBanner['status'] ?? true) ? 'checked' : ''; ?>> Active
                </label>
            </div>
            
            <button type="submit" name="<?php echo $action === 'add' ? 'add_banner' : 'edit_banner'; ?>" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $action === 'add' ? 'Add Banner' : 'Update Banner'; ?>
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <?php if (empty($banners)): ?>
        <div class="empty-state">
            <i class="fas fa-images"></i>
            <h3>No banners yet</h3>
            <p>Start by adding website banners</p>
            <a href="?action=add" class="btn btn-primary">Add First Banner</a>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Position</th>
                    <th>Button</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($banners as $banner): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($banner['title']); ?></strong>
                        <div style="font-size: 12px; color: var(--text-muted);"><?php echo htmlspecialchars(substr($banner['subtitle'] ?? '', 0, 50)); ?></div>
                    </td>
                    <td><span class="badge badge-info"><?php echo ucfirst($banner['position']); ?></span></td>
                    <td><?php echo $banner['button_text'] ?: '-'; ?></td>
                    <td>
                        <span class="badge badge-<?php echo $banner['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $banner['status'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="?action=edit&id=<?php echo $banner['id']; ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="banner_id" value="<?php echo $banner['id']; ?>">
                                <button type="submit" name="delete_banner" class="action-btn delete delete-btn">
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
