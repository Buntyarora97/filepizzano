<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category']) || isset($_POST['edit_category'])) {
        $name = sanitize($_POST['name']);
        $slug = generateSlug($name);
        $description = sanitize($_POST['description']);
        $icon = sanitize($_POST['icon']);
        $status = isset($_POST['status']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if (isset($_POST['add_category'])) {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, icon, status, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $description, $icon, $status, $sort_order]);
            $success = 'Category added successfully!';
        } else {
            $id = intval($_POST['category_id']);
            $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, icon = ?, status = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $description, $icon, $status, $sort_order, $id]);
            $success = 'Category updated successfully!';
        }
    }
    
    if (isset($_POST['delete_category'])) {
        $id = intval($_POST['category_id']);
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Category deleted successfully!';
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC")->fetchAll();

$editCategory = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editCategory = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Categories</h1>
        <p>Manage menu categories</p>
    </div>
    <?php if ($action === 'list'): ?>
    <a href="?action=add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
    </a>
    <?php else: ?>
    <a href="/admin/categories.php" class="btn btn-secondary">
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
        <h2><?php echo $action === 'add' ? 'Add New Category' : 'Edit Category'; ?></h2>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php if ($editCategory): ?>
            <input type="hidden" name="category_id" value="<?php echo $editCategory['id']; ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Category Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo $editCategory['name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Icon (Font Awesome class)</label>
                    <input type="text" name="icon" class="form-control" placeholder="e.g., fa-pizza-slice" value="<?php echo $editCategory['icon'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $editCategory['description'] ?? ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo $editCategory['sort_order'] ?? 0; ?>">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding-top: 10px;">
                        <input type="checkbox" name="status" <?php echo ($editCategory['status'] ?? true) ? 'checked' : ''; ?>> Active
                    </label>
                </div>
            </div>
            
            <button type="submit" name="<?php echo $action === 'add' ? 'add_category' : 'edit_category'; ?>" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $action === 'add' ? 'Add Category' : 'Update Category'; ?>
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <?php if (empty($categories)): ?>
        <div class="empty-state">
            <i class="fas fa-tags"></i>
            <h3>No categories yet</h3>
            <p>Start by adding menu categories</p>
            <a href="?action=add" class="btn btn-primary">Add First Category</a>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><i class="fas <?php echo $category['icon'] ?: 'fa-utensils'; ?>" style="font-size: 24px; color: var(--primary);"></i></td>
                    <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                    <td style="max-width: 300px;"><?php echo htmlspecialchars(substr($category['description'] ?? '', 0, 100)); ?></td>
                    <td><?php echo $category['sort_order']; ?></td>
                    <td>
                        <span class="badge badge-<?php echo $category['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $category['status'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="?action=edit&id=<?php echo $category['id']; ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                <button type="submit" name="delete_category" class="action-btn delete delete-btn">
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
