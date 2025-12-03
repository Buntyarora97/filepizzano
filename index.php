<?php
require_once __DIR__ . '/includes/header.php';

$heroBanners = getBanners('hero');
$featuredProducts = getProducts(null, 8, true, false);
$bestsellerProducts = getProducts(null, 8, false, true);
$offers = getOffers();
$testimonials = getTestimonials(10);
$galleryPhotos = getGallery('photo', 8);
$branches = getBranches();

$heroSection = getHomepageSection('hero');
$whySection = getHomepageSection('why_pizzano');
$bestsellersSection = getHomepageSection('bestsellers');
$offersSection = getHomepageSection('offers');
$branchesSection = getHomepageSection('branches');
$gallerySection = getHomepageSection('gallery');
$testimonialSection = getHomepageSection('testimonials');
$franchiseSection = getHomepageSection('franchise');
$newsletterSection = getHomepageSection('newsletter');
?>

<?php
$heroBanner = !empty($heroBanners) ? $heroBanners[0] : null;
$heroTitle = $heroBanner['title'] ?? ($heroSection['title'] ?? 'Pizzano - Where Every Slice Tells a Story');
$heroSubtitle = $heroBanner['subtitle'] ?? ($heroSection['subtitle'] ?? 'Experience the finest Italian cuisine crafted with love and premium ingredients. Fresh dough, signature sauces, and gourmet toppings - delivered hot to your doorstep in Bathinda & Dabwali.');
$heroButtonText = $heroBanner['button_text'] ?? 'Order Now';
$heroButtonLink = $heroBanner['button_link'] ?? '/menu.php';
?>
<section class="hero">
    <div class="hero-bg"></div>
    <div class="container">
        <div class="hero-content">
            <h1>
                Pizzano
                <span><?php echo htmlspecialchars(str_replace('Pizzano - ', '', $heroTitle)); ?></span>
            </h1>
            <p><?php echo htmlspecialchars($heroSubtitle); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo htmlspecialchars($heroButtonLink); ?>" class="btn btn-primary">
                    <i class="fas fa-utensils"></i> <?php echo htmlspecialchars($heroButtonText); ?>
                </a>
                <a href="/menu.php" class="btn btn-outline">
                    <i class="fas fa-book-open"></i> View Menu
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number counter" data-target="5000">0</span>+
                    <span class="stat-label">Happy Customers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number counter" data-target="50">0</span>+
                    <span class="stat-label">Menu Items</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2</span>
                    <span class="stat-label">Locations</span>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-pizza">
                <img src="/assets/images/gallery/pepperoni_pizza_product_shot.png" alt="Delicious Pizza">
            </div>
            <div class="hero-thumbnails">
                <div class="hero-thumb active">
                    <img src="/assets/images/gallery/pepperoni_pizza_product_shot.png" alt="Pepperoni Pizza">
                </div>
                <div class="hero-thumb">
                    <img src="/assets/images/gallery/farmhouse_veggie_pizza_shot.png" alt="Farmhouse Pizza">
                </div>
                <div class="hero-thumb">
                    <img src="/assets/images/gallery/bbq_chicken_pizza_shot.png" alt="BBQ Chicken Pizza">
                </div>
                <div class="hero-thumb">
                    <img src="/assets/images/gallery/penne_alfredo_pasta_dish.png" alt="Pasta">
                </div>
                <div class="hero-thumb">
                    <img src="/assets/images/gallery/garlic_bread_appetizer.png" alt="Garlic Bread">
                </div>
            </div>
            <div class="hero-nav">
                <button><i class="fas fa-chevron-left"></i></button>
                <button><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

<section class="section why-section">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $whySection['title'] ?? 'Why Choose Pizzano?'; ?></h2>
            <p><?php echo $whySection['subtitle'] ?? 'Three reasons that make us the best choice for Italian cuisine'; ?></p>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-bread-slice"></i>
                </div>
                <h3>Fresh Dough Daily</h3>
                <p>Our dough is made fresh every morning using premium flour and a secret blend of herbs. Hand-stretched to perfection for that authentic Italian crust.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-pepper-hot"></i>
                </div>
                <h3>Secret Sauce Recipe</h3>
                <p>Our signature tomato sauce is crafted from sun-ripened tomatoes, fresh basil, and a blend of Italian spices passed down through generations.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Chef Curated Menu</h3>
                <p>Every dish on our menu is personally crafted by our experienced Italian chefs who bring years of culinary expertise to your plate.</p>
            </div>
        </div>
    </div>
</section>

<section class="section category-section">
    <div class="container">
        <div class="section-header">
            <h2>Explore Our Menu</h2>
            <p>Browse through our delicious categories</p>
        </div>
        <div class="category-strip">
            <?php foreach ($categories as $cat): ?>
            <a href="/menu.php?category=<?php echo $cat['slug']; ?>" class="category-item">
                <i class="fas <?php echo $cat['icon'] ?: 'fa-utensils'; ?>"></i>
                <span><?php echo $cat['name']; ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section products-section">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $bestsellersSection['title'] ?? 'Our Best Sellers'; ?></h2>
            <p><?php echo $bestsellersSection['subtitle'] ?? 'Most loved dishes by our customers'; ?></p>
        </div>
        <div class="products-grid">
            <?php foreach ($bestsellerProducts as $product): ?>
            <div class="product-card">
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
        <div style="text-align: center; margin-top: 50px;">
            <a href="/menu.php" class="btn btn-primary">View Full Menu <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="section offers-section" id="offers">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $offersSection['title'] ?? 'Special Offers'; ?></h2>
            <p><?php echo $offersSection['subtitle'] ?? 'Amazing deals just for you'; ?></p>
        </div>
        <div class="offers-grid">
            <?php foreach ($offers as $offer): ?>
            <div class="offer-card">
                <div class="offer-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3><?php echo htmlspecialchars($offer['title']); ?></h3>
                <p><?php echo htmlspecialchars($offer['description']); ?></p>
                <?php if ($offer['code']): ?>
                <span class="offer-code"><?php echo $offer['code']; ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section products-section">
    <div class="container">
        <div class="section-header">
            <h2>Featured Items</h2>
            <p>Hand-picked by our chef for you</p>
        </div>
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo getProductImage($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-badges">
                        <?php if ($product['is_veg']): ?>
                        <span class="badge badge-veg">Veg</span>
                        <?php else: ?>
                        <span class="badge badge-nonveg">Non-Veg</span>
                        <?php endif; ?>
                        <?php if ($product['is_featured']): ?>
                        <span class="badge badge-new">Featured</span>
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
    </div>
</section>

<section class="section branches-section">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $branchesSection['title'] ?? 'Visit Our Branches'; ?></h2>
            <p><?php echo $branchesSection['subtitle'] ?? 'Two convenient locations to serve you better'; ?></p>
        </div>
        <div class="branches-grid">
            <div class="branch-card">
                <div class="branch-image">
                    <img src="/assets/images/gallery/restaurant_interior_ambiance.png" alt="Pizzano Bathinda">
                    <div class="branch-overlay"></div>
                </div>
                <div class="branch-content">
                    <h3><i class="fas fa-map-marker-alt"></i> Pizzano Bathinda</h3>
                    <div class="branch-info">
                        <div class="branch-info-item">
                            <i class="fas fa-location-dot"></i>
                            <span><?php echo BRANCH_BATHINDA['address']; ?></span>
                        </div>
                        <div class="branch-info-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo BRANCH_BATHINDA['hours']; ?></span>
                        </div>
                        <div class="branch-info-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo BRANCH_BATHINDA['phone']; ?></span>
                        </div>
                    </div>
                    <div class="branch-actions">
                        <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_BATHINDA['phone']); ?>" class="branch-btn call">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                        <a href="<?php echo BRANCH_BATHINDA['map_link']; ?>" target="_blank" class="branch-btn directions">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                </div>
            </div>
            <div class="branch-card">
                <div class="branch-image">
                    <img src="/assets/images/gallery/restaurant_interior_ambiance.png" alt="Pizzano Dabwali">
                    <div class="branch-overlay"></div>
                </div>
                <div class="branch-content">
                    <h3><i class="fas fa-map-marker-alt"></i> Pizzano Dabwali</h3>
                    <div class="branch-info">
                        <div class="branch-info-item">
                            <i class="fas fa-location-dot"></i>
                            <span><?php echo BRANCH_DABWALI['address']; ?></span>
                        </div>
                        <div class="branch-info-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo BRANCH_DABWALI['hours']; ?></span>
                        </div>
                        <div class="branch-info-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo BRANCH_DABWALI['phone']; ?></span>
                        </div>
                    </div>
                    <div class="branch-actions">
                        <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_DABWALI['phone']); ?>" class="branch-btn call">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                        <a href="<?php echo BRANCH_DABWALI['map_link']; ?>" target="_blank" class="branch-btn directions">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section gallery-section">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $gallerySection['title'] ?? 'Our Gallery'; ?></h2>
            <p><?php echo $gallerySection['subtitle'] ?? 'A glimpse into our world of flavors'; ?></p>
        </div>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="/assets/images/gallery/pepperoni_pizza_product_shot.png" alt="Pepperoni Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/farmhouse_veggie_pizza_shot.png" alt="Farmhouse Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/bbq_chicken_pizza_shot.png" alt="BBQ Chicken Pizza">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/penne_alfredo_pasta_dish.png" alt="Pasta">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/garlic_bread_appetizer.png" alt="Garlic Bread">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/chocolate_brownie_dessert.png" alt="Brownie">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
            <div class="gallery-item">
                <img src="/assets/images/gallery/restaurant_interior_ambiance.png" alt="Restaurant Interior">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="/gallery.php" class="btn btn-outline">View Full Gallery <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="section testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2><?php echo $testimonialSection['title'] ?? 'What Our Customers Say'; ?></h2>
            <p><?php echo $testimonialSection['subtitle'] ?? 'Real reviews from real food lovers'; ?></p>
        </div>
        <div class="testimonials-slider">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">
                        <?php echo strtoupper(substr($testimonial['name'], 0, 1)); ?>
                    </div>
                    <div class="testimonial-info">
                        <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                        <span><?php echo htmlspecialchars($testimonial['designation']); ?></span>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                    <i class="fas fa-star"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-content">"<?php echo htmlspecialchars($testimonial['content']); ?>"</p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section franchise-section">
    <div class="container">
        <div class="franchise-content">
            <h2><?php echo $franchiseSection['title'] ?? 'Own a Pizzano Franchise'; ?></h2>
            <p><?php echo $franchiseSection['subtitle'] ?? 'Join our growing family of successful franchisees. Low investment, high returns, and comprehensive support.'; ?></p>
            <a href="/franchise.php" class="franchise-btn">
                <i class="fas fa-handshake"></i> Enquire Now
            </a>
        </div>
    </div>
</section>

<section class="section instagram-section">
    <div class="container">
        <div class="section-header">
            <h2>Follow Us on Instagram</h2>
            <p>@pizzano_official</p>
        </div>
        <div class="instagram-grid">
            <div class="instagram-item">
                <img src="/assets/images/gallery/pepperoni_pizza_product_shot.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="instagram-item">
                <img src="/assets/images/gallery/farmhouse_veggie_pizza_shot.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="instagram-item">
                <img src="/assets/images/gallery/bbq_chicken_pizza_shot.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="instagram-item">
                <img src="/assets/images/gallery/penne_alfredo_pasta_dish.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="instagram-item">
                <img src="/assets/images/gallery/garlic_bread_appetizer.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="instagram-item">
                <img src="/assets/images/gallery/chocolate_brownie_dessert.png" alt="Instagram Post">
                <div class="instagram-overlay"><i class="fab fa-instagram"></i></div>
            </div>
        </div>
    </div>
</section>

<section class="section newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h2><?php echo $newsletterSection['title'] ?? 'Stay Updated'; ?></h2>
            <p><?php echo $newsletterSection['subtitle'] ?? 'Subscribe to our newsletter for exclusive offers and updates'; ?></p>
            <form class="newsletter-form" action="#" method="POST">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<style>
.hero-stats {
    display: flex;
    gap: 40px;
    margin-top: 40px;
}
.stat-item {
    text-align: center;
}
.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--gold);
    font-family: var(--font-heading);
}
.stat-label {
    display: block;
    font-size: 0.85rem;
    color: var(--gray);
    margin-top: 5px;
}
@media (max-width: 768px) {
    .hero-stats {
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>