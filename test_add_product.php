
<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

echo "<h2>Testing Product Addition - Ice Cream</h2>";

try {
    $pdo = getConnection();
    
    // First, check if desserts category exists
    $stmt = $pdo->query("SELECT * FROM categories WHERE slug = 'desserts'");
    $dessertCategory = $stmt->fetch();
    
    if (!$dessertCategory) {
        echo "<p style='color: red;'>Error: Desserts category not found. Creating it...</p>";
        $pdo->exec("INSERT INTO categories (name, slug, description, icon, sort_order, status) VALUES ('Desserts', 'desserts', 'Sweet treats to end your meal perfectly', 'fa-ice-cream', 5, 1)");
        $dessertCategory = $pdo->query("SELECT * FROM categories WHERE slug = 'desserts'")->fetch();
    }
    
    echo "<p style='color: green;'>✓ Desserts category found (ID: {$dessertCategory['id']})</p>";
    
    // Check if ice cream already exists
    $stmt = $pdo->query("SELECT * FROM products WHERE slug = 'vanilla-ice-cream'");
    $existingProduct = $stmt->fetch();
    
    if ($existingProduct) {
        echo "<p style='color: orange;'>⚠ Ice Cream product already exists. Updating it...</p>";
        
        $stmt = $pdo->prepare("UPDATE products SET 
            name = ?, 
            short_description = ?, 
            long_description = ?, 
            price = ?, 
            sale_price = ?, 
            category_id = ?, 
            is_veg = 1, 
            is_featured = 1, 
            is_new = 1, 
            image = ?,
            status = 1,
            updated_at = CURRENT_TIMESTAMP 
            WHERE slug = 'vanilla-ice-cream'");
        
        $stmt->execute([
            'Vanilla Ice Cream',
            'Premium vanilla ice cream made with real vanilla beans',
            'Indulge in our creamy, rich vanilla ice cream crafted with authentic Madagascar vanilla beans. Perfectly smooth texture with an intense vanilla flavor that melts in your mouth. Served in a generous scoop, it\'s the perfect way to end your meal or enjoy as a refreshing treat.',
            149,
            129,
            $dessertCategory['id'],
            'vanilla_ice_cream_dessert.png'
        ]);
        
        echo "<p style='color: green;'>✓ Ice Cream product updated successfully!</p>";
    } else {
        echo "<p style='color: blue;'>Adding new Ice Cream product...</p>";
        
        $stmt = $pdo->prepare("INSERT INTO products 
            (name, slug, short_description, long_description, price, sale_price, category_id, is_veg, is_featured, is_new, image, status, sort_order) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 1, ?, 1, 0)");
        
        $stmt->execute([
            'Vanilla Ice Cream',
            'vanilla-ice-cream',
            'Premium vanilla ice cream made with real vanilla beans',
            'Indulge in our creamy, rich vanilla ice cream crafted with authentic Madagascar vanilla beans. Perfectly smooth texture with an intense vanilla flavor that melts in your mouth. Served in a generous scoop, it\'s the perfect way to end your meal or enjoy as a refreshing treat.',
            149,
            129,
            $dessertCategory['id'],
            'vanilla_ice_cream_dessert.png'
        ]);
        
        echo "<p style='color: green;'>✓ Ice Cream product added successfully!</p>";
    }
    
    // Verify the product was added/updated
    $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = 'vanilla-ice-cream'");
    $product = $stmt->fetch();
    
    if ($product) {
        echo "<hr><h3>Product Details:</h3>";
        echo "<ul>";
        echo "<li><strong>Name:</strong> {$product['name']}</li>";
        echo "<li><strong>Category:</strong> {$product['category_name']}</li>";
        echo "<li><strong>Price:</strong> ₹{$product['price']}</li>";
        echo "<li><strong>Sale Price:</strong> ₹{$product['sale_price']}</li>";
        echo "<li><strong>Description:</strong> {$product['short_description']}</li>";
        echo "<li><strong>Image:</strong> {$product['image']}</li>";
        echo "<li><strong>Featured:</strong> " . ($product['is_featured'] ? 'Yes' : 'No') . "</li>";
        echo "<li><strong>New:</strong> " . ($product['is_new'] ? 'Yes' : 'No') . "</li>";
        echo "<li><strong>Status:</strong> " . ($product['status'] ? 'Active' : 'Inactive') . "</li>";
        echo "</ul>";
        
        echo "<hr><h3>Test Complete! ✓</h3>";
        echo "<p><a href='/menu.php' style='display: inline-block; padding: 10px 20px; background: #E85A1E; color: white; text-decoration: none; border-radius: 5px;'>View in Menu</a></p>";
        echo "<p><a href='/admin/products.php' style='display: inline-block; padding: 10px 20px; background: #333; color: white; text-decoration: none; border-radius: 5px;'>View in Admin Panel</a></p>";
    }
    
    // Test all database tables
    echo "<hr><h3>Database Tables Status:</h3>";
    $tables = ['categories', 'products', 'branches', 'banners', 'testimonials', 'gallery', 'admin_users'];
    foreach ($tables as $table) {
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "<p style='color: green;'>✓ $table: $count records</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ $table: Error - {$e->getMessage()}</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
