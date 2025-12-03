# Pizzano Restaurant Website

## Overview
Pizzano is a professional restaurant website for a pizza café with locations in Bathinda and Dabwali, India. The website features a complete restaurant management system with customer-facing pages and an admin panel.

## Project Information
- **Type**: Restaurant Website
- **Language**: PHP 8.2
- **Database**: SQLite
- **Status**: Development Ready (requires security hardening for production)

## Project Structure
```
.
├── admin/              # Admin panel for managing content
│   ├── includes/       # Admin panel headers/footers
│   ├── login.php       # Admin login page
│   ├── homepage.php    # Homepage content management
│   ├── products.php    # Product management
│   ├── categories.php  # Category management
│   ├── banners.php     # Banner management
│   ├── testimonials.php # Testimonial management
│   ├── gallery.php     # Gallery management
│   └── ...
├── assets/
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── images/        # Static images
├── config/
│   ├── config.php     # Main configuration
│   ├── database.php   # Database connection (SQLite)
│   └── ...
├── database/
│   ├── pizzano.db     # SQLite database file
│   ├── schema.sql     # Database schema
│   └── seed.sql       # Seed data
├── includes/
│   ├── header.php     # Main header template
│   ├── footer.php     # Main footer template
│   └── functions.php  # Helper functions
├── index.php          # Homepage
├── menu.php           # Menu page
├── about.php          # About page
├── contact.php        # Contact page
├── franchise.php      # Franchise inquiry page
└── gallery.php        # Gallery page
```

## Features
- **Customer-Facing**:
  - Homepage with hero section, product showcase, and testimonials
  - Menu page with category filtering
  - About Us page with company story
  - Gallery page with photos
  - Contact form for inquiries
  - Franchise inquiry form
  - Branch information (Bathinda & Dabwali)

- **Admin Panel**:
  - Secure login system (username: admin, password: admin123)
  - Product management (CRUD operations)
  - Category management
  - Banner management
  - Testimonial management
  - Gallery management
  - Contact inquiry management
  - Franchise inquiry management
  - SEO settings
  - Homepage content customization

## Database
The application supports both SQLite (local development) and MySQL (production on Hostinger). The database connection automatically switches based on environment variables.

**Development (SQLite)**:
- Database file: `database/pizzano.db`
- Used when MySQL environment variables are not set

**Production (MySQL on Hostinger)**:
- Set these environment variables: `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`
- Import `database/pizzano_mysql.sql` via phpMyAdmin

The database includes the following tables:
- `admin_users` - Admin user accounts
- `categories` - Product categories
- `products` - Menu items
- `branches` - Restaurant locations
- `banners` - Hero/promotional banners
- `testimonials` - Customer reviews
- `gallery` - Photo gallery items
- `contact_inquiries` - Contact form submissions
- `franchise_inquiries` - Franchise inquiry submissions
- `homepage_sections` - Homepage content sections
- `seo_pages` - SEO metadata
- `offers` - Special offers
- `blog_posts` - Blog content
- `instagram_reels` - Instagram integration

## Development
The site runs on PHP's built-in development server on port 5000:
```bash
php -S 0.0.0.0:5000 -t .
```

## Deployment
The application is configured for autoscale deployment on Replit. 

**Production Readiness Checklist**:
1. ✅ Error handling configured (display_errors disabled in production)
2. ⚠️ **REQUIRED**: Change default admin credentials before deployment
3. ⚠️ **NOTE**: Using PHP's built-in development server (suitable for small deployments)
4. ✅ CSRF protection enabled on forms
5. ✅ Input sanitization implemented
6. ✅ Cache control headers configured

**Before Deploying to Production**:
- Change the admin password (currently uses default: admin/admin123)
- Review and update branch information in `config/config.php`
- Update social media links in `config/config.php`
- Consider using a production-grade web server (Apache/Nginx) for high-traffic scenarios

## Admin Access
- **URL**: `/admin/login.php`
- **Default Username**: admin
- **Default Password**: admin123

**CRITICAL SECURITY NOTICE**: 
- The default admin credentials MUST be changed before deploying to production
- To change the password, log into the admin panel and update the credentials
- Never use default credentials in a live production environment

## Configuration
Key configuration settings are in `config/config.php`:
- Site name and tagline
- Branch information (addresses, phone numbers, hours)
- Social media links
- Admin email

## Recent Changes
- 2025-12-03: Completed full admin panel testing - all pages verified working
- 2025-12-03: Added admin_notes columns to contact_inquiries and franchise_inquiries tables
- 2025-12-03: Added city and opening_hours columns to branches table (dual-column setup for compatibility)
- 2025-12-03: Added sort_order and image columns to homepage_sections table
- 2025-12-03: Updated MySQL export file (pizzano_mysql.sql) with all schema fixes
- 2025-12-03: Fixed product edit image handling to preserve existing images when no new upload
- 2025-12-03: Added video_url and category columns to gallery table
- 2025-12-03: Configured for Replit environment

## Notes
- The database is automatically initialized with schema and seed data if it doesn't exist
- The site includes cache control headers to prevent browser caching issues
- All forms include CSRF protection
- Input sanitization is implemented throughout the application
