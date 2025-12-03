<?php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request. Please try again.';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        
        if (empty($name) || empty($phone)) {
            $error = 'Please fill in all required fields.';
        } else {
            if (saveFranchiseInquiry($_POST)) {
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
        <h1>Franchise Opportunities</h1>
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span>Franchise</span>
        </div>
    </div>
</div>

<section class="section franchise-intro">
    <div class="container">
        <div class="franchise-hero">
            <div class="franchise-hero-content">
                <h2>Own a Pizzano Restaurant</h2>
                <p class="lead">Join India's fastest-growing Italian restaurant chain and be part of our success story.</p>
                <p>With proven business model, comprehensive training, and ongoing support, Pizzano franchise offers an excellent opportunity for entrepreneurs who are passionate about food and customer service.</p>
                <div class="franchise-stats">
                    <div class="stat">
                        <span class="stat-value">25-30%</span>
                        <span class="stat-label">Profit Margin</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">18-24</span>
                        <span class="stat-label">Months ROI</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">500+</span>
                        <span class="stat-label">Sq. Ft. Area</span>
                    </div>
                </div>
            </div>
            <div class="franchise-hero-image">
                <img src="/assets/images/gallery/franchise.jpg" alt="Pizzano Franchise">
            </div>
        </div>
    </div>
</section>

<section class="section franchise-benefits">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose Pizzano Franchise?</h2>
            <p>Benefits of partnering with us</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Proven Business Model</h3>
                <p>Our tested and successful business model ensures profitability from day one.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Comprehensive Training</h3>
                <p>Complete training program covering operations, customer service, and management.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-bullhorn"></i></div>
                <h3>Marketing Support</h3>
                <p>Ongoing marketing and promotional support to drive customers to your outlet.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-truck"></i></div>
                <h3>Supply Chain</h3>
                <p>Established supply chain for consistent quality ingredients at best prices.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-headset"></i></div>
                <h3>Ongoing Support</h3>
                <p>Dedicated support team to help you at every step of your journey.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-award"></i></div>
                <h3>Brand Recognition</h3>
                <p>Leverage our strong brand presence and loyal customer base.</p>
            </div>
        </div>
    </div>
</section>

<section class="section franchise-investment">
    <div class="container">
        <div class="section-header">
            <h2>Investment Details</h2>
            <p>Transparent investment structure</p>
        </div>
        <div class="investment-grid">
            <div class="investment-card">
                <h3>Initial Investment</h3>
                <div class="investment-amount">₹15-25 Lakhs</div>
                <p>Including franchise fee, setup, equipment, and initial inventory</p>
            </div>
            <div class="investment-card">
                <h3>Franchise Fee</h3>
                <div class="investment-amount">₹5 Lakhs</div>
                <p>One-time fee for brand rights and initial training</p>
            </div>
            <div class="investment-card">
                <h3>Royalty</h3>
                <div class="investment-amount">5%</div>
                <p>Monthly royalty on gross sales</p>
            </div>
            <div class="investment-card">
                <h3>Marketing Fund</h3>
                <div class="investment-amount">2%</div>
                <p>Monthly contribution to national marketing fund</p>
            </div>
        </div>
    </div>
</section>

<section class="section franchise-process">
    <div class="container">
        <div class="section-header">
            <h2>How to Get Started</h2>
            <p>Simple steps to own a Pizzano franchise</p>
        </div>
        <div class="process-steps">
            <div class="process-step">
                <div class="step-number">1</div>
                <h3>Submit Enquiry</h3>
                <p>Fill out the franchise enquiry form with your details</p>
            </div>
            <div class="process-line"></div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3>Initial Discussion</h3>
                <p>Our team will contact you for initial discussion</p>
            </div>
            <div class="process-line"></div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3>Location Review</h3>
                <p>We help you select the perfect location</p>
            </div>
            <div class="process-line"></div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h3>Agreement</h3>
                <p>Sign franchise agreement and pay fees</p>
            </div>
            <div class="process-line"></div>
            <div class="process-step">
                <div class="step-number">5</div>
                <h3>Training & Setup</h3>
                <p>Complete training and restaurant setup</p>
            </div>
            <div class="process-line"></div>
            <div class="process-step">
                <div class="step-number">6</div>
                <h3>Grand Opening</h3>
                <p>Launch your Pizzano restaurant!</p>
            </div>
        </div>
    </div>
</section>

<section class="section contact-section" style="background: var(--dark);">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-wrap">
                <h3>Franchise Enquiry Form</h3>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you for your interest! Our franchise team will contact you within 48 hours.
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
                            <label>Full Name *</label>
                            <input type="text" name="name" required placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="tel" name="phone" required placeholder="Enter your phone number">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" placeholder="Which city are you interested in?">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" placeholder="Your state">
                        </div>
                        <div class="form-group">
                            <label>Investment Capacity</label>
                            <select name="investment">
                                <option value="">Select Investment Range</option>
                                <option value="15-20 Lakhs">₹15-20 Lakhs</option>
                                <option value="20-25 Lakhs">₹20-25 Lakhs</option>
                                <option value="25-30 Lakhs">₹25-30 Lakhs</option>
                                <option value="30+ Lakhs">₹30+ Lakhs</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Business Experience</label>
                        <textarea name="experience" placeholder="Tell us about your business experience (if any)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Additional Message</label>
                        <textarea name="message" placeholder="Any questions or additional information"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Enquiry
                    </button>
                </form>
            </div>
            
            <div class="franchise-info">
                <div class="contact-info-card">
                    <h3>Contact Our Franchise Team</h3>
                    <div class="quick-contact">
                        <a href="tel:+918288093880" class="quick-item">
                            <i class="fas fa-phone"></i>
                            <span>+91 82880-93880</span>
                        </a>
                        <a href="mailto:franchise@pizzano.in" class="quick-item">
                            <i class="fas fa-envelope"></i>
                            <span>franchise@pizzano.in</span>
                        </a>
                        <a href="https://wa.me/918288093880" class="quick-item" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp Us</span>
                        </a>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <h3>Available Territories</h3>
                    <p style="color: var(--gray); margin-bottom: 20px;">We are currently expanding in:</p>
                    <ul class="territory-list">
                        <li><i class="fas fa-check-circle"></i> Punjab</li>
                        <li><i class="fas fa-check-circle"></i> Haryana</li>
                        <li><i class="fas fa-check-circle"></i> Rajasthan</li>
                        <li><i class="fas fa-check-circle"></i> Himachal Pradesh</li>
                        <li><i class="fas fa-check-circle"></i> Chandigarh</li>
                        <li><i class="fas fa-check-circle"></i> Delhi NCR</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.franchise-intro {
    background: var(--darker);
}
.franchise-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}
.franchise-hero-content h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: var(--gold);
}
.franchise-hero-content .lead {
    font-size: 1.2rem;
    color: var(--light);
    margin-bottom: 15px;
}
.franchise-hero-content p {
    color: var(--gray);
    line-height: 1.8;
}
.franchise-stats {
    display: flex;
    gap: 40px;
    margin-top: 40px;
}
.franchise-stats .stat {
    text-align: center;
}
.franchise-stats .stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    font-family: var(--font-heading);
}
.franchise-stats .stat-label {
    color: var(--gray);
    font-size: 0.9rem;
}
.franchise-hero-image img {
    width: 100%;
    border-radius: 20px;
    box-shadow: var(--shadow-3d);
}
.franchise-benefits {
    background: var(--dark);
}
.benefits-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}
.benefit-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 35px;
    text-align: center;
    transition: var(--transition);
}
.benefit-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary-color);
}
.benefit-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--white);
}
.benefit-card h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
}
.benefit-card p {
    color: var(--gray);
    font-size: 0.9rem;
    line-height: 1.6;
}
.franchise-investment {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}
.investment-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}
.investment-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
}
.investment-card h3 {
    font-size: 1rem;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.8);
}
.investment-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--white);
    font-family: var(--font-heading);
    margin-bottom: 10px;
}
.investment-card p {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
}
.franchise-process {
    background: var(--darker);
}
.process-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}
.process-step {
    text-align: center;
    max-width: 150px;
}
.step-number {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    background: linear-gradient(135deg, var(--primary-color), var(--gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 700;
    color: var(--white);
}
.process-step h3 {
    font-size: 1rem;
    margin-bottom: 8px;
}
.process-step p {
    font-size: 0.8rem;
    color: var(--gray);
}
.process-line {
    width: 50px;
    height: 2px;
    background: var(--glass-border);
}
.franchise-info {
    display: flex;
    flex-direction: column;
    gap: 30px;
}
.territory-list {
    list-style: none;
}
.territory-list li {
    padding: 8px 0;
    color: var(--light);
    display: flex;
    align-items: center;
    gap: 10px;
}
.territory-list li i {
    color: var(--primary-color);
}

@media (max-width: 992px) {
    .franchise-hero {
        grid-template-columns: 1fr;
    }
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .investment-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .process-steps {
        flex-direction: column;
    }
    .process-line {
        width: 2px;
        height: 30px;
    }
}

@media (max-width: 768px) {
    .benefits-grid, .investment-grid {
        grid-template-columns: 1fr;
    }
    .franchise-stats {
        flex-direction: column;
        gap: 20px;
    }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
