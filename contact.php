<?php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request. Please try again.';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $subject = sanitize($_POST['subject'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        
        if (empty($name) || empty($message)) {
            $error = 'Please fill in all required fields.';
        } else {
            if (saveContactInquiry($_POST)) {
                $success = true;
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>

<div class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span>Contact</span>
        </div>
    </div>
</div>

<section class="section contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-wrap">
                <h3>Send us a Message</h3>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you for contacting us! We'll get back to you soon.
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" name="name" required placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" placeholder="What is this about?">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Your Message *</label>
                        <textarea name="message" required placeholder="Write your message here..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
            
            <div class="contact-info-wrap">
                <div class="contact-info-card">
                    <h3>Our Locations</h3>
                    
                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-content">
                            <h4>Pizzano Bathinda</h4>
                            <p><?php echo BRANCH_BATHINDA['address']; ?></p>
                            <p><i class="fas fa-phone"></i> <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_BATHINDA['phone']); ?>"><?php echo BRANCH_BATHINDA['phone']; ?></a></p>
                            <p><i class="fas fa-clock"></i> <?php echo BRANCH_BATHINDA['hours']; ?></p>
                            <a href="<?php echo BRANCH_BATHINDA['map_link']; ?>" target="_blank" class="btn btn-outline btn-sm">
                                <i class="fas fa-directions"></i> Get Directions
                            </a>
                        </div>
                    </div>
                    
                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-content">
                            <h4>Pizzano Dabwali</h4>
                            <p><?php echo BRANCH_DABWALI['address']; ?></p>
                            <p><i class="fas fa-phone"></i> <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_DABWALI['phone']); ?>"><?php echo BRANCH_DABWALI['phone']; ?></a></p>
                            <p><i class="fas fa-clock"></i> <?php echo BRANCH_DABWALI['hours']; ?></p>
                            <a href="<?php echo BRANCH_DABWALI['map_link']; ?>" target="_blank" class="btn btn-outline btn-sm">
                                <i class="fas fa-directions"></i> Get Directions
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <h3>Quick Contact</h3>
                    <div class="quick-contact">
                        <a href="mailto:info@pizzano.in" class="quick-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@pizzano.in</span>
                        </a>
                        <a href="https://wa.me/918288093880" class="quick-item" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp Us</span>
                        </a>
                    </div>
                    
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="<?php echo SOCIAL_LINKS['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo SOCIAL_LINKS['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo SOCIAL_LINKS['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="<?php echo SOCIAL_LINKS['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-info-wrap {
    display: flex;
    flex-direction: column;
    gap: 30px;
}
.contact-info-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    padding: 30px;
}
.contact-info-card h3 {
    font-size: 1.5rem;
    margin-bottom: 25px;
    color: var(--gold);
}
.contact-info-card h4 {
    font-size: 1.1rem;
    margin: 25px 0 15px;
}
.location-item {
    display: flex;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid var(--glass-border);
}
.location-item:last-of-type {
    border-bottom: none;
}
.location-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--white);
    flex-shrink: 0;
}
.location-content h4 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: var(--white);
}
.location-content p {
    color: var(--gray);
    font-size: 0.9rem;
    margin-bottom: 5px;
}
.location-content p a {
    color: var(--gray);
}
.location-content p a:hover {
    color: var(--primary-color);
}
.location-content p i {
    width: 20px;
    color: var(--primary-color);
}
.btn-sm {
    padding: 10px 20px;
    font-size: 13px;
    margin-top: 10px;
}
.quick-contact {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.quick-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    transition: var(--transition);
}
.quick-item:hover {
    background: rgba(232, 90, 30, 0.2);
}
.quick-item i {
    font-size: 24px;
    color: var(--primary-color);
}
.social-links {
    display: flex;
    gap: 15px;
}
.social-links a {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 18px;
    transition: var(--transition);
}
.social-links a:hover {
    background: var(--primary-color);
    transform: translateY(-5px);
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
