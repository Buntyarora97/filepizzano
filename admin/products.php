<?php
require_once __DIR__ . '/includes/header.php';

$pdo = getConnection();
$action = $_GET['action'] ?? 'list';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product']) || isset($_POST['edit_product'])) {
        $name = sanitize($_POST['name']);
        $slug = generateSlug($name);
        $short_desc = sanitize($_POST['short_description']);
        $description = sanitize($_POST['long_description']);
        $price = floatval($_POST['price']);
        $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null;
        $category_id = intval($_POST['category_id']);
        $is_veg = isset($_POST['is_veg']) ? 1 : 0;
        $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_new = isset($_POST['is_new']) ? 1 : 0;
        $prep_time = sanitize($_POST['prep_time']);
        $sku = sanitize($_POST['sku']);
        $status = isset($_POST['status']) ? 1 : 0;
        $meta_title = sanitize($_POST['meta_title']);
        $meta_desc = sanitize($_POST['meta_description']);

        // Handle image upload
        $newImage = '';
        $imageUploadSuccess = false;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['image']['name'])) {
            $upload_dir = __DIR__ . '/../assets/images/products/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = generateSlug($name) . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $newImage = $new_filename;
                $imageUploadSuccess = true;
            }
        }
        
        // Determine final image value
        $existingImage = !empty($_POST['existing_image']) ? $_POST['existing_image'] : '';
        $image = $imageUploadSuccess ? $newImage : $existingImage;

        if (isset($_POST['add_product'])) {
            $stmt = $pdo->prepare("INSERT INTO products (name, slug, short_description, description, price, sale_price, category_id, is_veg, is_bestseller, is_featured, is_new, prep_time, sku, status, meta_title, meta_description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $short_desc, $description, $price, $sale_price, $category_id, $is_veg, $is_bestseller, $is_featured, $is_new, $prep_time, $sku, $status, $meta_title, $meta_desc, $image]);
            $success = 'Product added successfully!';
        } else {
            $id = intval($_POST['product_id']);
            
            // Only update image column if a new image was successfully uploaded
            if ($imageUploadSuccess) {
                $stmt = $pdo->prepare("UPDATE products SET name = ?, slug = ?, short_description = ?, description = ?, price = ?, sale_price = ?, category_id = ?, is_veg = ?, is_bestseller = ?, is_featured = ?, is_new = ?, prep_time = ?, sku = ?, status = ?, meta_title = ?, meta_description = ?, image = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $params = [$name, $slug, $short_desc, $description, $price, $sale_price, $category_id, $is_veg, $is_bestseller, $is_featured, $is_new, $prep_time, $sku, $status, $meta_title, $meta_desc, $newImage, $id];
            } else {
                // Keep existing image - don't update the image column
                $stmt = $pdo->prepare("UPDATE products SET name = ?, slug = ?, short_description = ?, description = ?, price = ?, sale_price = ?, category_id = ?, is_veg = ?, is_bestseller = ?, is_featured = ?, is_new = ?, prep_time = ?, sku = ?, status = ?, meta_title = ?, meta_description = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $params = [$name, $slug, $short_desc, $description, $price, $sale_price, $category_id, $is_veg, $is_bestseller, $is_featured, $is_new, $prep_time, $sku, $status, $meta_title, $meta_desc, $id];
            }
            $stmt->execute($params);
            $success = 'Product updated successfully!';
        }
    }

    if (isset($_POST['delete_product'])) {
        $id = intval($_POST['product_id']);
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $success = 'Product deleted successfully!';
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();

$editProduct = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([intval($_GET['id'])]);
    $editProduct = $stmt->fetch();
}
?>

<div class="top-bar">
    <div class="page-title">
        <h1>Products</h1>
        <p>Manage your menu items</p>
    </div>
    <?php if ($action === 'list'): ?>
    <a href="?action=add" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
    <?php else: ?>
    <a href="/admin/products.php" class="btn btn-secondary">
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
        <h2><?php echo $action === 'add' ? 'Add New Product' : 'Edit Product'; ?></h2>
    </div>
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
            <?php if ($editProduct): ?>
            <input type="hidden" name="product_id" value="<?php echo $editProduct['id']; ?>">
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($editProduct['name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control" value="<?php echo htmlspecialchars($editProduct['sku'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea name="short_description" class="form-control" rows="2"><?php echo htmlspecialchars($editProduct['short_description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Long Description</label>
                <textarea name="long_description" class="form-control" rows="4"><?php echo htmlspecialchars($editProduct['long_description'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price *</label>
                    <input type="number" name="price" class="form-control" step="0.01" required value="<?php echo $editProduct['price'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Sale Price</label>
                    <input type="number" name="sale_price" class="form-control" step="0.01" value="<?php echo $editProduct['sale_price'] ?? ''; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($editProduct['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Prep Time</label>
                    <input type="text" name="prep_time" class="form-control" placeholder="e.g., 15-20 mins" value="<?php echo htmlspecialchars($editProduct['prep_time'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if ($action === 'edit' && !empty($editProduct['image'])): ?>
                    <small class="text-muted">Current: <?php echo htmlspecialchars($editProduct['image']); ?></small>
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editProduct['image']); ?>">
                <?php endif; ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Meta Title (SEO)</label>
                    <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($editProduct['meta_title'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Meta Description (SEO)</label>
                    <input type="text" name="meta_description" class="form-control" value="<?php echo htmlspecialchars($editProduct['meta_description'] ?? ''); ?>">
                </div>
            </div>

            <div style="display: flex; gap: 30px; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_veg" <?php echo ($editProduct['is_veg'] ?? true) ? 'checked' : ''; ?>> Vegetarian
                </label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_bestseller" <?php echo ($editProduct['is_bestseller'] ?? false) ? 'checked' : ''; ?>> Bestseller
                </label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" <?php echo ($editProduct['is_featured'] ?? false) ? 'checked' : ''; ?>> Featured
                </label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_new" <?php echo ($editProduct['is_new'] ?? false) ? 'checked' : ''; ?>> New
                </label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" <?php echo ($editProduct['status'] ?? true) ? 'checked' : ''; ?>> Active
                </label>
            </div>

            <button type="submit" name="<?php echo $action === 'add' ? 'add_product' : 'edit_product'; ?>" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo $action === 'add' ? 'Add Product' : 'Update Product'; ?>
            </button>
        </form>
    </div>
</div>

<?php else: ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($products)): ?>
        <div class="empty-state">
            <i class="fas fa-pizza-slice"></i>
            <h3>No products yet</h3>
            <p>Start adding products to your menu</p>
            <a href="?action=add" class="btn btn-primary">Add First Product</a>
        </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <img src="<?php echo getProductImage($product['image']); ?>" alt="" class="product-thumb">
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                        <div style="font-size: 12px; color: var(--text-muted);">
                            <?php if ($product['is_bestseller']): ?><span class="badge badge-warning">Bestseller</span><?php endif; ?>
                            <?php if ($product['is_featured']): ?><span class="badge badge-info">Featured</span><?php endif; ?>
                            <?php if ($product['is_new']): ?><span class="badge badge-success">New</span><?php endif; ?>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($product['category_name'] ?? '-'); ?></td>
                    <td>
                        <?php if ($product['sale_price']): ?>
                        <span style="text-decoration: line-through; color: var(--text-muted);">₹<?php echo $product['price']; ?></span>
                        <strong style="color: var(--primary);">₹<?php echo $product['sale_price']; ?></strong>
                        <?php else: ?>
                        <strong>₹<?php echo $product['price']; ?></strong>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo $product['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $product['status'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="?action=edit&id=<?php echo $product['id']; ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete_product" class="action-btn delete delete-btn">
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