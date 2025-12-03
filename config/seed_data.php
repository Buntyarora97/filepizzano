<?php
require_once __DIR__ . '/database.php';

$pdo = getConnection();

try {
    // Insert default admin user
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO admin_users (username, password, email, full_name) VALUES ('admin', '$adminPassword', 'admin@pizzano.in', 'Super Admin')");
    
    // Insert branches
    $pdo->exec("INSERT IGNORE INTO branches (name, address, phone, email, hours, map_link, sort_order) VALUES 
        ('Pizzano Bathinda', 'The Mall Road, Bathinda', '+91 82880-93880', 'bathinda@pizzano.in', '11:00 AM - 11:00 PM', 'https://maps.google.com/?q=Pizzano+Mall+Road+Bathinda', 1),
        ('Pizzano Dabwali', 'Colony Road, Mandi Dabwali, Near PNB Bank', '+91 98968-45577', 'dabwali@pizzano.in', '11:00 AM - 11:00 PM', 'https://maps.google.com/?q=Pizzano+Colony+Road+Mandi+Dabwali', 2)");
    
    // Insert categories
    $pdo->exec("INSERT IGNORE INTO categories (name, slug, description, icon, sort_order) VALUES 
        ('Pizzas', 'pizzas', 'Delicious handcrafted pizzas with premium toppings', 'fa-pizza-slice', 1),
        ('Pastas', 'pastas', 'Authentic Italian pasta dishes', 'fa-utensils', 2),
        ('Starters', 'starters', 'Mouth-watering appetizers to begin your meal', 'fa-drumstick-bite', 3),
        ('Breads', 'breads', 'Freshly baked artisan breads', 'fa-bread-slice', 4),
        ('Desserts', 'desserts', 'Sweet treats to end your meal perfectly', 'fa-ice-cream', 5),
        ('Beverages', 'beverages', 'Refreshing drinks and shakes', 'fa-glass-cheers', 6),
        ('Combos', 'combos', 'Value meal combinations for family and parties', 'fa-box', 7)");
    
    // Insert sample products
    $pdo->exec("INSERT IGNORE INTO products (name, slug, short_description, description, price, sale_price, image, category_id, is_veg, is_bestseller, is_featured, is_new) VALUES 
        ('Margherita Pizza', 'margherita-pizza', 'Classic Italian pizza with fresh mozzarella, tomatoes, and basil', 'The timeless classic! Our Margherita features hand-stretched dough, San Marzano tomato sauce, fresh mozzarella di bufala, aromatic basil leaves, and a drizzle of extra virgin olive oil.', 299, 249, 'margherita.jpg', 1, 1, 1, 1, 0),
        ('Pepperoni Supreme', 'pepperoni-supreme', 'Loaded with premium pepperoni and cheese', 'A meat lovers dream! Generous layers of spicy pepperoni, mozzarella cheese, and our signature tomato sauce on a perfectly crispy crust.', 399, null, 'pepperoni.jpg', 1, 0, 1, 0, 0),
        ('Farmhouse Pizza', 'farmhouse-pizza', 'Fresh vegetables on a crispy crust', 'Garden fresh vegetables including bell peppers, onions, mushrooms, olives, and tomatoes on our signature cheese base.', 349, null, 'farmhouse.jpg', 1, 1, 0, 1, 1),
        ('BBQ Chicken Pizza', 'bbq-chicken-pizza', 'Smoky BBQ sauce with tender chicken', 'Tender grilled chicken, smoky BBQ sauce, red onions, and a blend of cheeses create this irresistible combination.', 449, 399, 'bbq-chicken.jpg', 1, 0, 1, 0, 0),
        ('Penne Alfredo', 'penne-alfredo', 'Creamy white sauce pasta', 'Al dente penne pasta tossed in our rich, creamy Alfredo sauce with parmesan cheese and herbs.', 279, null, 'penne-alfredo.jpg', 2, 1, 0, 1, 0),
        ('Spaghetti Bolognese', 'spaghetti-bolognese', 'Classic meat sauce pasta', 'Traditional Italian pasta with slow-cooked meat sauce, fresh herbs, and parmesan.', 329, null, 'spaghetti.jpg', 2, 0, 0, 0, 0),
        ('Garlic Bread', 'garlic-bread', 'Crispy bread with garlic butter', 'Freshly baked bread with aromatic garlic butter and herbs. Perfect starter!', 129, 99, 'garlic-bread.jpg', 4, 1, 1, 0, 0),
        ('Cheesy Garlic Bread', 'cheesy-garlic-bread', 'Garlic bread loaded with cheese', 'Our signature garlic bread topped with melted mozzarella and cheddar cheese.', 179, null, 'cheesy-garlic-bread.jpg', 4, 1, 0, 1, 1),
        ('Chicken Wings', 'chicken-wings', 'Crispy fried chicken wings', 'Golden crispy chicken wings served with your choice of dipping sauce.', 299, null, 'chicken-wings.jpg', 3, 0, 1, 0, 0),
        ('French Fries', 'french-fries', 'Crispy golden fries', 'Hand-cut potatoes fried to golden perfection, served with ketchup.', 149, 129, 'french-fries.jpg', 3, 1, 0, 1, 0),
        ('Chocolate Brownie', 'chocolate-brownie', 'Rich chocolate brownie', 'Warm, gooey chocolate brownie served with vanilla ice cream.', 199, null, 'brownie.jpg', 5, 1, 0, 1, 0),
        ('Tiramisu', 'tiramisu', 'Classic Italian dessert', 'Layers of coffee-soaked ladyfingers and mascarpone cream.', 249, null, 'tiramisu.jpg', 5, 1, 1, 0, 0),
        ('Cold Coffee', 'cold-coffee', 'Refreshing iced coffee', 'Chilled coffee blended with ice cream for a creamy treat.', 149, null, 'cold-coffee.jpg', 6, 1, 0, 1, 0),
        ('Mojito', 'mojito', 'Fresh mint mocktail', 'Refreshing blend of lime, mint, and soda. Perfect for hot days!', 129, null, 'mojito.jpg', 6, 1, 0, 0, 1),
        ('Family Feast Combo', 'family-feast-combo', 'Perfect for family of 4', '2 Large Pizzas + Garlic Bread + Pasta + 4 Cold Drinks + Brownie', 1299, 999, 'family-combo.jpg', 7, 1, 1, 1, 0),
        ('Party Pack', 'party-pack', 'Ideal for parties of 8-10', '4 Large Pizzas + 2 Pasta + 2 Garlic Bread + 10 Cold Drinks + 2 Brownies', 2499, 1999, 'party-combo.jpg', 7, 1, 1, 0, 0)");
    
    // Insert gallery images
    $pdo->exec("INSERT IGNORE INTO gallery (title, image, type, sort_order) VALUES 
        ('Farmhouse Veggie Pizza', 'gallery/farmhouse_veggie_pizza_shot.png', 'photo', 1),
        ('Pepperoni Pizza', 'gallery/pepperoni_pizza_product_shot.png', 'photo', 2),
        ('Garlic Bread', 'gallery/garlic_bread_appetizer.png', 'photo', 3),
        ('BBQ Chicken Pizza', 'gallery/bbq_chicken_pizza_shot.png', 'photo', 4),
        ('Penne Alfredo Pasta', 'gallery/penne_alfredo_pasta_dish.png', 'photo', 5),
        ('Chocolate Brownie', 'gallery/chocolate_brownie_dessert.png', 'photo', 6),
        ('Restaurant Interior', 'gallery/restaurant_interior_ambiance.png', 'photo', 7),
        ('Chef in Action', 'gallery/pizza_chef_action_shot.png', 'photo', 8)");
    
    // Insert testimonials
    $pdo->exec("INSERT IGNORE INTO testimonials (name, designation, content, rating, sort_order) VALUES 
        ('Rahul Sharma', 'Food Blogger', 'Best pizza in Bathinda! The crust is perfectly crispy and the toppings are always fresh. Pizzano never disappoints!', 5, 1),
        ('Priya Singh', 'Regular Customer', 'We order from Pizzano every weekend. The family combo is great value and the delivery is always on time.', 5, 2),
        ('Amit Verma', 'Business Owner', 'Had their catering for my office party. Everyone loved the food! Professional service and delicious pizzas.', 5, 3),
        ('Neha Gupta', 'Food Enthusiast', 'The Tiramisu here is to die for! And their pasta selection is amazing. Highly recommend!', 5, 4),
        ('Vikram Joshi', 'Dabwali Resident', 'So happy that Pizzano opened in Dabwali. Now we dont have to travel to Bathinda for great pizza!', 5, 5)");
    
    // Insert homepage sections
    $pdo->exec("INSERT IGNORE INTO homepage_sections (section_key, title, subtitle) VALUES 
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
        ('instagram', 'Follow Us on Instagram', 'Check out our latest posts and reels')");
    
    // Insert SEO data for pages
    $pdo->exec("INSERT IGNORE INTO seo_pages (page_slug, meta_title, meta_description, meta_keywords) VALUES 
        ('home', 'Pizzano - Best Pizza Restaurant in Bathinda & Dabwali | Order Online', 'Pizzano offers the finest pizzas, pastas, and Italian cuisine in Bathinda and Dabwali. Order online for delivery or dine-in. Fresh ingredients, authentic taste!', 'pizza bathinda, pizza dabwali, italian restaurant, pizzano, best pizza, order pizza online'),
        ('menu', 'Menu | Pizzano - Pizzas, Pastas, Starters & More', 'Explore our delicious menu featuring handcrafted pizzas, authentic pastas, crispy starters, fresh breads, and decadent desserts. Order now!', 'pizza menu, pasta menu, italian food menu, pizzano menu'),
        ('about', 'About Pizzano - Our Story, Team & Values', 'Learn about Pizzanos journey, our passionate team, and commitment to quality. We bring authentic Italian flavors to Bathinda and Dabwali.', 'about pizzano, pizza restaurant story, italian cuisine'),
        ('contact', 'Contact Pizzano - Bathinda & Dabwali Locations', 'Get in touch with Pizzano. Visit us at Mall Road Bathinda or Colony Road Dabwali. Call us for reservations and orders.', 'contact pizzano, pizza delivery bathinda, pizza delivery dabwali'),
        ('franchise', 'Franchise Opportunities | Own a Pizzano Restaurant', 'Join the Pizzano family! Explore franchise opportunities and start your own successful pizza business. Low investment, high returns.', 'pizza franchise, restaurant franchise, food franchise india'),
        ('gallery', 'Photo Gallery | Pizzano Restaurant', 'Browse through our gallery showcasing our delicious pizzas, cozy ambiance, and happy customers.', 'pizzano photos, restaurant gallery, food photography')");
    
    // Insert sample offers
    $pdo->exec("INSERT IGNORE INTO offers (title, description, code, discount_type, discount_value) VALUES 
        ('Free Delivery', 'Free delivery on orders above Rs 499', 'FREEDEL', 'fixed', 0),
        ('20% Off First Order', 'Get 20% off on your first order', 'FIRST20', 'percentage', 20),
        ('Weekend Special', 'Buy 2 pizzas get 1 free every weekend', 'WEEKEND', 'percentage', 33),
        ('Family Combo Deal', 'Save Rs 300 on Family Feast Combo', 'FAMILY300', 'fixed', 300)");
    
    // Insert sample banners
    $pdo->exec("INSERT IGNORE INTO banners (title, subtitle, button_text, button_link, image, position, sort_order) VALUES 
        ('Pizzano - Where Every Slice Tells a Story', 'Experience authentic Italian flavors crafted with passion', 'Order Now', '/menu.php', 'hero-banner-1.jpg', 'hero', 1),
        ('Fresh From Our Stone Oven', 'Hand-tossed dough, premium ingredients, perfect taste', 'View Menu', '/menu.php', 'hero-banner-2.jpg', 'hero', 2),
        ('New: BBQ Chicken Pizza', 'Smoky, spicy, absolutely delicious!', 'Try Now', '/menu.php#bbq-chicken', 'promo-banner.jpg', 'promo', 1)");

    echo "Seed data inserted successfully!\n";
    echo "\n✅ Database में सभी data insert हो गया है:\n";
    echo "- Categories (7)\n";
    echo "- Products (16)\n";
    echo "- Branches (2)\n";
    echo "- Gallery (8)\n";
    echo "- Testimonials (5)\n";
    echo "- Homepage Sections (11)\n";
    echo "- SEO Pages (6)\n";
    echo "- Offers (4)\n";
    echo "- Banners (3)\n";
    echo "\n🔐 Admin Login:\n";
    echo "URL: /admin/login.php\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
