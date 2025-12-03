<?php
require_once __DIR__ . '/functions.php';

$categories = getCategories();
$branches = getBranches();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$seo = getSeoData($currentPage === 'index' ? 'home' : $currentPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title><?php echo $seo['meta_title'] ?? SITE_NAME . ' - ' . SITE_TAGLINE; ?></title>
    <meta name="description" content="<?php echo $seo['meta_description'] ?? 'Pizzano - Best Pizza Restaurant in Bathinda & Dabwali'; ?>">
    <meta name="keywords" content="<?php echo $seo['meta_keywords'] ?? 'pizza, restaurant, bathinda, dabwali, italian food'; ?>">

    <meta property="og:title" content="<?php echo $seo['meta_title'] ?? SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo $seo['meta_description'] ?? ''; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/images/logo.png">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <link rel="canonical" href="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <link rel="icon" type="image/png" href="/assets/images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Restaurant",
        "name": "Pizzano",
        "image": "<?php echo SITE_URL; ?>/assets/images/logo.png",
        "address": [
            {
                "@type": "PostalAddress",
                "streetAddress": "The Mall Road",
                "addressLocality": "Bathinda",
                "addressRegion": "Punjab",
                "addressCountry": "IN"
            },
            {
                "@type": "PostalAddress",
                "streetAddress": "Colony Road, Near PNB Bank",
                "addressLocality": "Mandi Dabwali",
                "addressRegion": "Haryana",
                "addressCountry": "IN"
            }
        ],
        "telephone": ["+91 82880-93880", "+91 98968-45577"],
        "servesCuisine": ["Italian", "Pizza", "Pasta"],
        "priceRange": "₹₹",
        "openingHours": "Mo-Su 11:00-23:00"
    }
    </script>
</head>
<body>
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <a href="tel:+918288093880"><i class="fas fa-phone-alt"></i> +918288093880</a>
                <a href="mailto:info@pizzano.in"><i class="fas fa-envelope"></i> info@pizzano.in</a>
            </div>
            <div class="top-bar-center">
                <div class="marquee">
                    <span>🍕 Free Delivery on orders above ₹499 | 🎉 20% Off on First Order - Use Code: FIRST20 | 📍 Now serving in Bathinda & Dabwali</span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="social-icons">
                    <a href="<?php echo SOCIAL_LINKS['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo SOCIAL_LINKS['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo SOCIAL_LINKS['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
                <a href="/franchise.php" class="franchise-btn">Franchise Enquiry</a>
            </div>
        </div>
    </div>

    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="logo">
                <img src="/assets/images/logo.png" alt="Pizzano Logo">
            </a>

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="/" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>">Home</a></li>
                <li class="has-dropdown">
                    <a href="/menu.php" class="<?php echo $currentPage === 'menu' ? 'active' : ''; ?>">Menu <i class="fas fa-chevron-down"></i></a>
                    <div class="mega-menu">
                        <div class="mega-menu-grid">
                            <?php foreach ($categories as $cat): ?>
                            <div class="mega-menu-item">
                                <a href="/menu.php?category=<?php echo $cat['slug']; ?>">
                                    <i class="fas <?php echo $cat['icon'] ?: 'fa-utensils'; ?>"></i>
                                    <span><?php echo $cat['name']; ?></span>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
                <li><a href="/menu.php#offers" class="<?php echo $currentPage === 'offers' ? 'active' : ''; ?>">Offers</a></li>
                <li class="has-dropdown">
                    <a href="#">Branches <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown">
                        <?php if (!empty($branches) && is_array($branches)): ?>
                            <?php foreach ($branches as $branch): ?>
                            <li><a href="/branch.php?id=<?php echo $branch['slug'] ?? ''; ?>"><?php echo htmlspecialchars($branch['city'] ?? $branch['name'] ?? 'Branch'); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <li><a href="/franchise.php" class="<?php echo $currentPage === 'franchise' ? 'active' : ''; ?>">Franchise</a></li>
                <li><a href="/gallery.php" class="<?php echo $currentPage === 'gallery' ? 'active' : ''; ?>">Gallery</a></li>
                <li class="has-dropdown">
                    <a href="/about.php" class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>">About Us <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown">
                        <li><a href="/about.php#our-story">Our Story</a></li>
                        <li><a href="/about.php#our-team">Our Team</a></li>
                        <li><a href="/about.php#sustainability">Sustainability</a></li>
                    </ul>
                </li>
                <li><a href="/contact.php" class="<?php echo $currentPage === 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>

            <div class="nav-icons">
                <button class="nav-icon search-btn" id="searchBtn"><i class="fas fa-search"></i></button>
                <a href="/menu.php" class="nav-icon cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-badge">0</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="search-modal" id="searchModal">
        <div class="search-modal-content">
            <button class="close-search" id="closeSearch"><i class="fas fa-times"></i></button>
            <form action="/menu.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for pizzas, pastas, and more..." autofocus>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <main>