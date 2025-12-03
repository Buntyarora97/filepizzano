
-- Seed Data for Pizzano

-- Admin User (Username: admin, Password: admin123)
INSERT OR IGNORE INTO admin_users (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@pizzano.in', 'Super Admin');

-- Categories
INSERT OR IGNORE INTO categories (name, slug, description, icon, sort_order) VALUES
('Pizzas', 'pizzas', 'Delicious handcrafted pizzas', 'fa-pizza-slice', 1),
('Pastas', 'pastas', 'Authentic Italian pasta', 'fa-utensils', 2),
('Starters', 'starters', 'Mouth-watering appetizers', 'fa-drumstick-bite', 3),
('Breads', 'breads', 'Freshly baked breads', 'fa-bread-slice', 4),
('Desserts', 'desserts', 'Sweet treats', 'fa-ice-cream', 5),
('Beverages', 'beverages', 'Refreshing drinks', 'fa-glass-cheers', 6);

-- Sample Products
INSERT OR IGNORE INTO products (name, slug, short_description, long_description, price, sale_price, image, category_id, is_veg, is_bestseller, is_featured) VALUES
('Margherita Pizza', 'margherita-pizza', 'Classic Italian pizza', 'Fresh mozzarella, tomatoes, and basil', 299, 249, 'margherita.jpg', 1, 1, 1, 1),
('Pepperoni Supreme', 'pepperoni-supreme', 'Loaded with pepperoni', 'Premium pepperoni and cheese', 399, NULL, 'pepperoni.jpg', 1, 0, 1, 0);

-- Branches
INSERT OR IGNORE INTO branches (name, address, phone, hours, sort_order) VALUES
('Pizzano Bathinda', 'The Mall Road, Bathinda', '+91 82880-93880', '11:00 AM - 11:00 PM', 1),
('Pizzano Dabwali', 'Colony Road, Mandi Dabwali', '+91 98968-45577', '11:00 AM - 11:00 PM', 2);
