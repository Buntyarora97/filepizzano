<?php
require_once __DIR__ . '/../config/config.php';

function getCategories($activeOnly = true) {
    $pdo = getConnection();
    $sql = "SELECT * FROM categories";
    if ($activeOnly) {
        $sql .= " WHERE status = 1";
    }
    $sql .= " ORDER BY sort_order ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getProducts($categoryId = null, $limit = null, $featured = false, $bestseller = false) {
    $pdo = getConnection();
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.status = 1";

    $params = [];

    if ($categoryId) {
        $sql .= " AND p.category_id = ?";
        $params[] = $categoryId;
    }

    if ($featured) {
        $sql .= " AND p.is_featured = true";
    }

    if ($bestseller) {
        $sql .= " AND p.is_bestseller = true";
    }

    $sql .= " ORDER BY p.sort_order ASC, p.id DESC";

    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getProductBySlug($slug) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

function getBranches() {
    return [
        [
            'id' => 1,
            'name' => 'Pizzano Bathinda',
            'slug' => 'bathinda',
            'city' => 'Bathinda',
            'address' => BRANCH_BATHINDA['address'],
            'phone' => BRANCH_BATHINDA['phone'],
            'hours' => BRANCH_BATHINDA['hours'],
            'map_link' => BRANCH_BATHINDA['map_link']
        ],
        [
            'id' => 2,
            'name' => 'Pizzano Dabwali',
            'slug' => 'dabwali',
            'city' => 'Dabwali',
            'address' => BRANCH_DABWALI['address'],
            'phone' => BRANCH_DABWALI['phone'],
            'hours' => BRANCH_DABWALI['hours'],
            'map_link' => BRANCH_DABWALI['map_link']
        ]
    ];
}

function getBanners($position = 'hero') {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM banners WHERE position = ? AND status = 1 ORDER BY sort_order ASC");
    $stmt->execute([$position]);
    return $stmt->fetchAll();
}

function getTestimonials($limit = 10) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE status = 1 ORDER BY sort_order ASC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getGallery($type = null, $limit = 12) {
    $pdo = getConnection();
    $sql = "SELECT * FROM gallery WHERE status = 1";
    $params = [];

    if ($type) {
        $sql .= " AND type = ?";
        $params[] = $type;
    }

    $sql .= " ORDER BY sort_order ASC LIMIT " . (int)$limit;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getOffers($activeOnly = true) {
    $pdo = getConnection();
    $sql = "SELECT * FROM offers WHERE status = 1";
    if ($activeOnly) {
        $sql .= " AND (valid_until IS NULL OR valid_until >= CURRENT_DATE)";
    }
    $sql .= " ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getHomepageSection($key) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM homepage_sections WHERE section_key = ? AND status = 1");
    $stmt->execute([$key]);
    return $stmt->fetch();
}

function getSeoData($pageSlug) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM seo_pages WHERE page_slug = ?");
    $stmt->execute([$pageSlug]);
    return $stmt->fetch();
}

function getInstagramReels($limit = 6) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM instagram_reels WHERE status = 1 ORDER BY sort_order ASC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getBlogPosts($limit = 3) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE status = 1 ORDER BY created_at DESC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function saveContactInquiry($data) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("INSERT INTO contact_inquiries (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        sanitize($data['name']),
        sanitize($data['email']),
        sanitize($data['phone']),
        sanitize($data['subject']),
        sanitize($data['message'])
    ]);
}

function saveFranchiseInquiry($data) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("INSERT INTO franchise_inquiries (name, email, phone, city, state, investment_capacity, experience, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        sanitize($data['name']),
        sanitize($data['email']),
        sanitize($data['phone']),
        sanitize($data['city']),
        sanitize($data['state']),
        sanitize($data['investment']),
        sanitize($data['experience']),
        sanitize($data['message'])
    ]);
}

function formatPrice($price) {
    return '₹' . number_format($price, 0);
}

// Updated function to fix the 'long_description' issue. The database column is 'description'.
function addProduct($data) {
    $pdo = getConnection();
    $sql = "INSERT INTO products (name, slug, category_id, price, sale_price, image, description, is_featured, is_bestseller, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        sanitize($data['name']),
        generateSlug($data['name']),
        (int)$data['category_id'],
        (float)$data['price'],
        (isset($data['sale_price']) && $data['sale_price'] !== '') ? (float)$data['sale_price'] : null,
        $data['image'], // This should be the filename, not the full path
        sanitize($data['description']), // Changed from long_description to description
        isset($data['is_featured']) ? 1 : 0,
        isset($data['is_bestseller']) ? 1 : 0,
        isset($data['status']) ? (int)$data['status'] : 1
    ]);
}

function getProductImage($imageName) {
    if (empty($imageName)) {
        return '/assets/images/products/hero-pizza.jpg'; // Default image
    }
    // Check if it's a full URL
    if (filter_var($imageName, FILTER_VALIDATE_URL)) {
        return $imageName;
    }
    // Assuming images are in /assets/images/products/
    return '/assets/images/products/' . $imageName;
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function generateSlug($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}
?>