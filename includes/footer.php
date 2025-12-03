    </main>

    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col footer-about">
                        <a href="/" class="footer-logo">
                            <img src="/assets/images/logo.png" alt="Pizzano">
                        </a>
                        <p>Experience the finest Italian cuisine crafted with love and premium ingredients. Two locations serving Bathinda and Dabwali.</p>
                        <div class="footer-social">
                            <a href="<?php echo SOCIAL_LINKS['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo SOCIAL_LINKS['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="<?php echo SOCIAL_LINKS['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a href="<?php echo SOCIAL_LINKS['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="/menu.php">Menu</a></li>
                            <li><a href="/about.php">About Us</a></li>
                            <li><a href="/gallery.php">Gallery</a></li>
                            <li><a href="/franchise.php">Franchise</a></li>
                            <li><a href="/contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-col">
                        <h4>Menu Categories</h4>
                        <ul>
                            <?php foreach ($categories as $cat): ?>
                            <li><a href="/menu.php?category=<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="footer-col footer-branches">
                        <h4>Our Branches</h4>
                        <div class="branch-info">
                            <h5><i class="fas fa-map-marker-alt"></i> Bathinda</h5>
                            <p><?php echo BRANCH_BATHINDA['address']; ?></p>
                            <p><i class="fas fa-phone"></i> <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_BATHINDA['phone']); ?>"><?php echo BRANCH_BATHINDA['phone']; ?></a></p>
                            <p><i class="fas fa-clock"></i> <?php echo BRANCH_BATHINDA['hours']; ?></p>
                        </div>
                        <div class="branch-info">
                            <h5><i class="fas fa-map-marker-alt"></i> Dabwali</h5>
                            <p><?php echo BRANCH_DABWALI['address']; ?></p>
                            <p><i class="fas fa-phone"></i> <a href="tel:<?php echo str_replace([' ', '-'], '', BRANCH_DABWALI['phone']); ?>"><?php echo BRANCH_DABWALI['phone']; ?></a></p>
                            <p><i class="fas fa-clock"></i> <?php echo BRANCH_DABWALI['hours']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> Pizzano. All Rights Reserved.</p>
                    <div class="payment-icons">
                        <span>We Accept:</span>
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-google-pay"></i>
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/918288093880" class="whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <button class="scroll-top" id="scrollTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script src="/assets/js/main.js"></script>
</body>
</html>
