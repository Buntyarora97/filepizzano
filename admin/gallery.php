<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_image']) || isset($_POST['edit_image'])) {
        $title = sanitize($_POST['title']);
        $image = sanitize($_POST['image']);
        $type = sanitize($_POST['type']);
        $video_url = sanitize($_POST['video_url']);
        $category = sanitize($_POST['category']);
        $status = isset($_POST['status']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if (isset($_POST['add_image'])) {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, image, type, video_url, category, status, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $image, $type, $video_url, $category, $status, $sort_order]);
            $success = 'Gallery item added successfully!';
        } else {
            $id = intval($_POST['gallery_id']);
            $stmt = $pdo->prepare("UPDATE gallery SET title = ?, image = ?, type = ?, video_url = ?, category = ?, status = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$title, $image, $type, $video_url, $category, $status, $sort_order, $id]);
            $success = 'Gallery item updated successfully!';
        }
    }
    
    if (isset($_POST['delete_image'])) {
        $id = intval($_POST['gallery_id']);
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Gallery item deleted successfully!';
    }
}

$gallery = $pdo->query("SELECT * FROM gallery ORDER BY sort_order")->fetchAll();

$editGallery = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editGallery = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Gallery</h1>
        <p>Manage photos and videos</p>
    </div>
    <?php if ($action === 'list'): ?>
    <a href="?action=add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Image
    </a>
    <?php else: ?>
    <a href="/admin/gallery.php" class="btn btn-secondary">
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
        <h2><?php echo $action === 'add' ? 'Add New Gallery Item' : 'Edit Gallery Item'; ?></h2>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php if ($editGallery): ?>
            <input type="hidden" name="gallery_id" value="<?php echo $editGallery['id']; ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $editGallery['title'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="photo" <?php echo ($editGallery['type'] ?? '') === 'photo' ? 'selected' : ''; ?>>Photo</option>
                        <option value="video" <?php echo ($editGallery['type'] ?? '') === 'video' ? 'selected' : ''; ?>>Video</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Image URL *</label>
                <input type="text" name="image" class="form-control" required value="<?php echo $editGallery['image'] ?? ''; ?>">
            </div>
            
            <div class="form-group">
                <label>Video URL (if video type)</label>
                <input type="text" name="video_url" class="form-control" placeholder="YouTube or embed URL" value="<?php echo $editGallery['video_url'] ?? ''; ?>">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control">
                        <option value="food" <?php echo ($editGallery['category'] ?? '') === 'food' ? 'selected' : ''; ?>>Food</option>
                        <option value="restaurant" <?php echo ($editGallery['category'] ?? '') === 'restaurant' ? 'selected' : ''; ?>>Restaurant</option>
                        <option value="events" <?php echo ($editGallery['category'] ?? '') === 'events' ? 'selected' : ''; ?>>Events</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo $editGallery['sort_order'] ?? 0; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" <?php echo ($editGallery['status'] ?? true) ? 'checked' : ''; ?>> Active
                </label>
            </div>
            
            <button type="submit" name="<?php echo $action === 'add' ? 'add_image' : 'edit_image'; ?>" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $action === 'add' ? 'Add Gallery Item' : 'Update Gallery Item'; ?>
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <?php if (empty($gallery)): ?>
        <div class="empty-state">
            <i class="fas fa-photo-video"></i>
            <h3>No gallery items yet</h3>
            <p>Start by adding photos and videos</p>
            <a href="?action=add" class="btn btn-primary">Add First Item</a>
        </div>
        <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            <?php foreach ($gallery as $item): ?>
            <div style="background: var(--body-bg); border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color);">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" style="width: 100%; height: 150px; object-fit: cover;">
                <div style="padding: 15px;">
                    <h4 style="font-size: 14px; margin-bottom: 5px;"><?php echo htmlspecialchars($item['title'] ?: 'Untitled'); ?></h4>
                    <span class="badge badge-<?php echo $item['status'] ? 'success' : 'danger'; ?>"><?php echo $item['status'] ? 'Active' : 'Inactive'; ?></span>
                    <div class="actions" style="margin-top: 10px;">
                        <a href="?action=edit&id=<?php echo $item['id']; ?>" class="action-btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="gallery_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="delete_image" class="action-btn delete delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
