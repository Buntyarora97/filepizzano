<?php
require_once __DIR__ . '/includes/header.php';

$selectedCategory = isset($_GET['category']) ? sanitize($_GET['category']) : null;
$searchQuery = isset($_GET['search']) ? sanitize($_GET['search']) : null;

$products = getProducts();

if ($selectedCategory) {
    $products = array_filter($products, function($p) use ($selectedCategory) {
        return $p['category_slug'] === $selectedCategory;
    });
}

if ($searchQuery) {
    $products = array_filter($products, function($p) use ($searchQuery) {
        return stripos($p['name'], $searchQuery) !== false || 
               stripos($p['short_description'], $searchQuery) !== false;
    });
}
?>

<div class="page-header">
    <div class="container">
        <h1>Our Menu</h1>
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span>Menu</span>
        </div>
    </div>
</div>

<section class="section" style="padding-top: 50px;">
    <div class="container">
        <div class="menu-filters">
            <div class="filter-tabs">
                <a href="/menu.php" class="filter-tab <?php echo !$selectedCategory ? 'active' : ''; ?>">All</a>
                <?php foreach ($categories as $cat): ?>
                <a href="/menu.php?category=<?php echo $cat['slug']; ?>" 
                   class="filter-tab <?php echo $selectedCategory === $cat['slug'] ? 'active' : ''; ?>">
                    <i class="fas <?php echo $cat['icon'] ?: 'fa-utensils'; ?>"></i>
                    <?php echo $cat['name']; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if (empty($products)): ?>
        <div class="no-products">
            <i class="fas fa-search"></i>
            <h3>No products found</h3>
            <p>Try a different category or search term</p>
            <a href="/menu.php" class="btn btn-primary">View All Products</a>
        </div>
        <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?php echo $product['category_slug']; ?>">
                <div class="product-image">
                    <img src="<?php echo getProductImage($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-badges">
                        <?php if ($product['is_veg']): ?>
                        <span class="badge badge-veg">Veg</span>
                        <?php else: ?>
                        <span class="badge badge-nonveg">Non-Veg</span>
                        <?php endif; ?>
                        <?php if ($product['is_bestseller']): ?>
                        <span class="badge badge-bestseller">Bestseller</span>
                        <?php endif; ?>
                        <?php if ($product['is_new']): ?>
                        <span class="badge badge-new">New</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="product-content">
                    <span class="product-category"><?php echo $product['category_name'] ?? 'Food'; ?></span>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['short_description']); ?></p>
                    <div class="product-footer">
                        <div class="product-price">
                            <span class="price-current"><?php echo formatPrice($product['sale_price'] ?: $product['price']); ?></span>
                            <?php if ($product['sale_price']): ?>
                            <span class="price-old"><?php echo formatPrice($product['price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <button class="add-to-cart"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.menu-filters {
    margin-bottom: 50px;
}
.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}
.filter-tab {
    padding: 12px 25px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--glass-border);
    border-radius: 50px;
    color: var(--white);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}
.filter-tab:hover,
.filter-tab.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
}
.filter-tab i {
    font-size: 14px;
}
.no-products {
    text-align: center;
    padding: 80px 20px;
}
.no-products i {
    font-size: 60px;
    color: var(--gray);
    margin-bottom: 20px;
}
.no-products h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}
.no-products p {
    color: var(--gray);
    margin-bottom: 30px;
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
