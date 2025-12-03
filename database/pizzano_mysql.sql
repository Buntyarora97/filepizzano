-- Pizzano Database MySQL Export
-- Import this file into your Hostinger phpMyAdmin
-- =====================================================
-- IMPORTANT: Change the admin password after importing!
-- Default Login: admin / admin123
-- =====================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- DROP ALL TABLES FIRST (in correct order)
-- =====================================================
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `admin_users`;
DROP TABLE IF EXISTS `branches`;
DROP TABLE IF EXISTS `banners`;
DROP TABLE IF EXISTS `testimonials`;
DROP TABLE IF EXISTS `gallery`;
DROP TABLE IF EXISTS `offers`;
DROP TABLE IF EXISTS `homepage_sections`;
DROP TABLE IF EXISTS `seo_pages`;
DROP TABLE IF EXISTS `blog_posts`;
DROP TABLE IF EXISTS `instagram_reels`;
DROP TABLE IF EXISTS `contact_inquiries`;
DROP TABLE IF EXISTS `franchise_inquiries`;

-- =====================================================
-- CREATE TABLES
-- =====================================================

-- Admin Users
CREATE TABLE `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100),
    `full_name` VARCHAR(100),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) UNIQUE NOT NULL,
    `icon` VARCHAR(50),
    `description` TEXT,
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT,
    `name` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(200) UNIQUE NOT NULL,
    `short_description` TEXT,
    `long_description` TEXT,
    `price` DECIMAL(10,2) NOT NULL,
    `sale_price` DECIMAL(10,2),
    `image` VARCHAR(255),
    `is_veg` INT DEFAULT 1,
    `is_featured` INT DEFAULT 0,
    `is_bestseller` INT DEFAULT 0,
    `is_new` INT DEFAULT 0,
    `prep_time` VARCHAR(50),
    `sku` VARCHAR(50),
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `meta_title` VARCHAR(200),
    `meta_description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Branches
CREATE TABLE `branches` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `address` TEXT NOT NULL,
    `city` VARCHAR(100),
    `phone` VARCHAR(20),
    `email` VARCHAR(100),
    `hours` VARCHAR(100),
    `opening_hours` VARCHAR(100),
    `map_link` TEXT,
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Banners
CREATE TABLE `banners` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200),
    `subtitle` TEXT,
    `image` VARCHAR(255),
    `button_text` VARCHAR(50),
    `button_link` VARCHAR(255),
    `position` VARCHAR(50) DEFAULT 'hero',
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Testimonials
CREATE TABLE `testimonials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `designation` VARCHAR(100),
    `content` TEXT NOT NULL,
    `rating` INT DEFAULT 5,
    `image` VARCHAR(255),
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Gallery (with video_url and category columns)
CREATE TABLE `gallery` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200),
    `image` VARCHAR(255) NOT NULL,
    `type` VARCHAR(20) DEFAULT 'photo',
    `video_url` VARCHAR(500) DEFAULT NULL,
    `category` VARCHAR(50) DEFAULT 'food',
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Offers
CREATE TABLE `offers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT,
    `code` VARCHAR(50),
    `discount_type` VARCHAR(20),
    `discount_value` DECIMAL(10,2),
    `valid_until` DATE,
    `status` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Homepage Sections
CREATE TABLE `homepage_sections` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `section_key` VARCHAR(50) UNIQUE NOT NULL,
    `title` VARCHAR(200),
    `subtitle` TEXT,
    `content` TEXT,
    `image` VARCHAR(255),
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SEO Pages
CREATE TABLE `seo_pages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `page_slug` VARCHAR(100) UNIQUE NOT NULL,
    `meta_title` VARCHAR(200),
    `meta_description` TEXT,
    `meta_keywords` TEXT,
    `og_title` VARCHAR(200),
    `og_description` TEXT,
    `og_image` VARCHAR(255),
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Blog Posts
CREATE TABLE `blog_posts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(200) UNIQUE NOT NULL,
    `excerpt` TEXT,
    `content` TEXT,
    `featured_image` VARCHAR(255),
    `author` VARCHAR(100),
    `status` INT DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Instagram Reels
CREATE TABLE `instagram_reels` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200),
    `reel_url` TEXT NOT NULL,
    `thumbnail` VARCHAR(255),
    `status` INT DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contact Inquiries
CREATE TABLE `contact_inquiries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20),
    `subject` VARCHAR(200),
    `message` TEXT NOT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `admin_notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Franchise Inquiries
CREATE TABLE `franchise_inquiries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20),
    `city` VARCHAR(100),
    `state` VARCHAR(100),
    `investment_capacity` VARCHAR(50),
    `experience` TEXT,
    `message` TEXT,
    `status` VARCHAR(20) DEFAULT 'new',
    `admin_notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- INSERT SEED DATA
-- =====================================================

-- Admin User (Username: admin, Password: admin123)
-- CHANGE THIS PASSWORD IMMEDIATELY AFTER SETUP!
INSERT INTO `admin_users` (`username`, `password`, `email`, `full_name`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@pizzano.in', 'Super Admin');

-- Branches
INSERT INTO `branches` (`name`, `address`, `phone`, `email`, `hours`, `map_link`, `sort_order`) VALUES
('Pizzano Bathinda', 'The Mall Road, Bathinda', '+91 82880-93880', 'bathinda@pizzano.in', '11:00 AM - 11:00 PM', 'https://maps.google.com/?q=Pizzano+Mall+Road+Bathinda', 1),
('Pizzano Dabwali', 'Colony Road, Mandi Dabwali, Near PNB Bank', '+91 98968-45577', 'dabwali@pizzano.in', '11:00 AM - 11:00 PM', 'https://maps.google.com/?q=Pizzano+Colony+Road+Mandi+Dabwali', 2);

-- Categories
INSERT INTO `categories` (`name`, `slug`, `description`, `icon`, `sort_order`) VALUES
('Pizzas', 'pizzas', 'Delicious handcrafted pizzas with premium toppings', 'fa-pizza-slice', 1),
('Pastas', 'pastas', 'Authentic Italian pasta dishes', 'fa-utensils', 2),
('Starters', 'starters', 'Mouth-watering appetizers to begin your meal', 'fa-drumstick-bite', 3),
('Breads', 'breads', 'Freshly baked artisan breads', 'fa-bread-slice', 4),
('Desserts', 'desserts', 'Sweet treats to end your meal perfectly', 'fa-ice-cream', 5),
('Beverages', 'beverages', 'Refreshing drinks and shakes', 'fa-glass-cheers', 6),
('Combos', 'combos', 'Value meal combinations for family and parties', 'fa-box', 7);

-- Products
INSERT INTO `products` (`name`, `slug`, `short_description`, `long_description`, `price`, `sale_price`, `image`, `category_id`, `is_veg`, `is_bestseller`, `is_featured`, `is_new`) VALUES
('Margherita Pizza', 'margherita-pizza', 'Classic Italian pizza with fresh mozzarella, tomatoes, and basil', 'The timeless classic! Our Margherita features hand-stretched dough, San Marzano tomato sauce, fresh mozzarella di bufala, aromatic basil leaves, and a drizzle of extra virgin olive oil.', 299, 249, 'margherita.jpg', 1, 1, 1, 1, 0),
('Pepperoni Supreme', 'pepperoni-supreme', 'Loaded with premium pepperoni and cheese', 'A meat lovers dream! Generous layers of spicy pepperoni, mozzarella cheese, and our signature tomato sauce on a perfectly crispy crust.', 399, NULL, 'pepperoni.jpg', 1, 0, 1, 0, 0),
('Farmhouse Pizza', 'farmhouse-pizza', 'Fresh vegetables on a crispy crust', 'Garden fresh vegetables including bell peppers, onions, mushrooms, olives, and tomatoes on our signature cheese base.', 349, NULL, 'farmhouse.jpg', 1, 1, 0, 1, 1),
('BBQ Chicken Pizza', 'bbq-chicken-pizza', 'Smoky BBQ sauce with tender chicken', 'Tender grilled chicken, smoky BBQ sauce, red onions, and a blend of cheeses create this irresistible combination.', 449, 399, 'bbq-chicken.jpg', 1, 0, 1, 0, 0),
('Penne Alfredo', 'penne-alfredo', 'Creamy white sauce pasta', 'Al dente penne pasta tossed in our rich, creamy Alfredo sauce with parmesan cheese and herbs.', 279, NULL, 'penne-alfredo.jpg', 2, 1, 0, 1, 0),
('Spaghetti Bolognese', 'spaghetti-bolognese', 'Classic meat sauce pasta', 'Traditional Italian pasta with slow-cooked meat sauce, fresh herbs, and parmesan.', 329, NULL, 'spaghetti.jpg', 2, 0, 0, 0, 0),
('Garlic Bread', 'garlic-bread', 'Crispy bread with garlic butter', 'Freshly baked bread with aromatic garlic butter and herbs. Perfect starter!', 129, 99, 'garlic-bread.jpg', 4, 1, 1, 0, 0),
('Cheesy Garlic Bread', 'cheesy-garlic-bread', 'Garlic bread loaded with cheese', 'Our signature garlic bread topped with melted mozzarella and cheddar cheese.', 179, NULL, 'cheesy-garlic-bread.jpg', 4, 1, 0, 1, 1),
('Chicken Wings', 'chicken-wings', 'Crispy fried chicken wings', 'Golden crispy chicken wings served with your choice of dipping sauce.', 299, NULL, 'chicken-wings.jpg', 3, 0, 1, 0, 0),
('French Fries', 'french-fries', 'Crispy golden fries', 'Hand-cut potatoes fried to golden perfection, served with ketchup.', 149, 129, 'french-fries.jpg', 3, 1, 0, 1, 0),
('Chocolate Brownie', 'chocolate-brownie', 'Rich chocolate brownie', 'Warm, gooey chocolate brownie served with vanilla ice cream.', 199, NULL, 'brownie.jpg', 5, 1, 0, 1, 0),
('Tiramisu', 'tiramisu', 'Classic Italian dessert', 'Layers of coffee-soaked ladyfingers and mascarpone cream.', 249, NULL, 'tiramisu.jpg', 5, 1, 1, 0, 0),
('Cold Coffee', 'cold-coffee', 'Refreshing iced coffee', 'Chilled coffee blended with ice cream for a creamy treat.', 149, NULL, 'cold-coffee.jpg', 6, 1, 0, 1, 0),
('Mojito', 'mojito', 'Fresh mint mocktail', 'Refreshing blend of lime, mint, and soda. Perfect for hot days!', 129, NULL, 'mojito.jpg', 6, 1, 0, 0, 1),
('Family Feast Combo', 'family-feast-combo', 'Perfect for family of 4', '2 Large Pizzas + Garlic Bread + Pasta + 4 Cold Drinks + Brownie', 1299, 999, 'family-combo.jpg', 7, 1, 1, 1, 0),
('Party Pack', 'party-pack', 'Ideal for parties of 8-10', '4 Large Pizzas + 2 Pasta + 2 Garlic Bread + 10 Cold Drinks + 2 Brownies', 2499, 1999, 'party-combo.jpg', 7, 1, 1, 0, 0);

-- Gallery (with category field)
INSERT INTO `gallery` (`title`, `image`, `type`, `category`, `sort_order`) VALUES
('Farmhouse Veggie Pizza', '/assets/images/gallery/farmhouse_veggie_pizza_shot.png', 'photo', 'food', 1),
('Pepperoni Pizza', '/assets/images/gallery/pepperoni_pizza_product_shot.png', 'photo', 'food', 2),
('Garlic Bread', '/assets/images/gallery/garlic_bread_appetizer.png', 'photo', 'food', 3),
('BBQ Chicken Pizza', '/assets/images/gallery/bbq_chicken_pizza_shot.png', 'photo', 'food', 4),
('Penne Alfredo Pasta', '/assets/images/gallery/penne_alfredo_pasta_dish.png', 'photo', 'food', 5),
('Chocolate Brownie', '/assets/images/gallery/chocolate_brownie_dessert.png', 'photo', 'food', 6),
('Restaurant Interior', '/assets/images/gallery/restaurant_interior_ambiance.png', 'photo', 'restaurant', 7),
('Chef in Action', '/assets/images/gallery/pizza_chef_action_shot.png', 'photo', 'restaurant', 8);

-- Testimonials
INSERT INTO `testimonials` (`name`, `designation`, `content`, `rating`, `sort_order`) VALUES
('Rahul Sharma', 'Food Blogger', 'Best pizza in Bathinda! The crust is perfectly crispy and the toppings are always fresh. Pizzano never disappoints!', 5, 1),
('Priya Singh', 'Regular Customer', 'We order from Pizzano every weekend. The family combo is great value and the delivery is always on time.', 5, 2),
('Amit Verma', 'Business Owner', 'Had their catering for my office party. Everyone loved the food! Professional service and delicious pizzas.', 5, 3),
('Neha Gupta', 'Food Enthusiast', 'The Tiramisu here is to die for! And their pasta selection is amazing. Highly recommend!', 5, 4),
('Vikram Joshi', 'Dabwali Resident', 'So happy that Pizzano opened in Dabwali. Now we dont have to travel to Bathinda for great pizza!', 5, 5);

-- Homepage Sections
INSERT INTO `homepage_sections` (`section_key`, `title`, `subtitle`) VALUES
('hero', 'Welcome to Pizzano', 'Experience the finest Italian cuisine crafted with love and premium ingredients'),
('why_pizzano', 'Why Choose Pizzano?', 'Three reasons that make us special'),
('bestsellers', 'Our Best Sellers', 'Most loved dishes by our customers'),
('offers', 'Special Offers', 'Amazing deals just for you'),
('branches', 'Visit Our Branches', 'Two convenient locations to serve you'),
('chef_special', 'Chefs Recommendation', 'Handpicked by our master chef'),
('gallery', 'Our Gallery', 'A glimpse into our world'),
('testimonials', 'What Our Customers Say', 'Real reviews from real food lovers'),
('franchise', 'Own a Pizzano Franchise', 'Join our growing family of successful franchisees'),
('newsletter', 'Stay Updated', 'Subscribe for exclusive offers and updates'),
('instagram', 'Follow Us on Instagram', 'Check out our latest posts and reels');

-- SEO Pages
INSERT INTO `seo_pages` (`page_slug`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
('home', 'Pizzano - Best Pizza Restaurant in Bathinda & Dabwali | Order Online', 'Pizzano offers the finest pizzas, pastas, and Italian cuisine in Bathinda and Dabwali. Order online for delivery or dine-in. Fresh ingredients, authentic taste!', 'pizza bathinda, pizza dabwali, italian restaurant, pizzano, best pizza, order pizza online'),
('menu', 'Menu | Pizzano - Pizzas, Pastas, Starters & More', 'Explore our delicious menu featuring handcrafted pizzas, authentic pastas, crispy starters, fresh breads, and decadent desserts. Order now!', 'pizza menu, pasta menu, italian food menu, pizzano menu'),
('about', 'About Pizzano - Our Story, Team & Values', 'Learn about Pizzanos journey, our passionate team, and commitment to quality. We bring authentic Italian flavors to Bathinda and Dabwali.', 'about pizzano, pizza restaurant story, italian cuisine'),
('contact', 'Contact Pizzano - Bathinda & Dabwali Locations', 'Get in touch with Pizzano. Visit us at Mall Road Bathinda or Colony Road Dabwali. Call us for reservations and orders.', 'contact pizzano, pizza delivery bathinda, pizza delivery dabwali'),
('franchise', 'Franchise Opportunities | Own a Pizzano Restaurant', 'Join the Pizzano family! Explore franchise opportunities and start your own successful pizza business. Low investment, high returns.', 'pizza franchise, restaurant franchise, food franchise india'),
('gallery', 'Photo Gallery | Pizzano Restaurant', 'Browse through our gallery showcasing our delicious pizzas, cozy ambiance, and happy customers.', 'pizzano photos, restaurant gallery, food photography');

-- Offers
INSERT INTO `offers` (`title`, `description`, `code`, `discount_type`, `discount_value`) VALUES
('Free Delivery', 'Free delivery on orders above Rs 499', 'FREEDEL', 'fixed', 0),
('20% Off First Order', 'Get 20% off on your first order', 'FIRST20', 'percentage', 20),
('Weekend Special', 'Buy 2 pizzas get 1 free every weekend', 'WEEKEND', 'percentage', 33),
('Family Combo Deal', 'Save Rs 300 on Family Feast Combo', 'FAMILY300', 'fixed', 300);

-- Banners
INSERT INTO `banners` (`title`, `subtitle`, `button_text`, `button_link`, `image`, `position`, `sort_order`) VALUES
('Pizzano - Where Every Slice Tells a Story', 'Experience authentic Italian flavors crafted with passion', 'Order Now', '/menu.php', '/assets/images/products/hero-pizza.jpg', 'hero', 1),
('Fresh From Our Stone Oven', 'Hand-tossed dough, premium ingredients, perfect taste', 'View Menu', '/menu.php', '/assets/images/products/hero-pizza.jpg', 'hero', 2),
('New: BBQ Chicken Pizza', 'Smoky, spicy, absolutely delicious!', 'Try Now', '/menu.php', '/assets/images/gallery/bbq_chicken_pizza_shot.png', 'promo', 1);

-- =====================================================
-- HOSTINGER DEPLOYMENT INSTRUCTIONS:
-- =====================================================
-- 1. Log into your Hostinger hPanel
-- 2. Go to Databases > MySQL Databases
-- 3. Create a new database (e.g., pizzano_db)
-- 4. Note down: Database Name, Username, Password, Host
-- 5. Go to phpMyAdmin
-- 6. Select your new database
-- 7. Click "Import" tab
-- 8. Choose this file and click "Go"
-- 9. Update your config/database.php or .env file with:
--    DB_HOST = your_hostinger_host (usually localhost or mysql.hostinger.com)
--    DB_NAME = your_database_name
--    DB_USER = your_database_user
--    DB_PASSWORD = your_database_password
-- 10. IMPORTANT: Change admin password after first login!
-- =====================================================
