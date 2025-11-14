<footer class="footer bg-dark text-light py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-4">
                    <div class="d-flex align-items-center">
                        <div class="logo-container me-2">
                            <div class="logo-square-white"></div>
                        </div>
                        <h5 class="footer-title mb-0">ContinuServe</h5>
                    </div>
                </div>
                <p class="footer-description">
                    A trusted subsidiary of Quattro Business Support Services, providing comprehensive business solutions 
                    and expert support to help your organization thrive in today's competitive marketplace.
                </p>
                
                <!-- Contact Info -->
                <div class="contact-info mt-4">
                    <div class="contact-item mb-2">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <span>+1 (555) 123-4567</span>
                    </div>
                    <div class="contact-item mb-2">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <a href="mailto:info@continuserve.com" class="text-light-emphasis">info@continuserve.com</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <span>123 Business Ave, Suite 100<br>New York, NY 10001</span>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="social-links mt-4">
                    <a href="https://linkedin.com/company/continuserve" class="social-link me-3" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://twitter.com/continuserve" class="social-link me-3" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://facebook.com/continuserve" class="social-link me-3" target="_blank" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://youtube.com/continuserve" class="social-link" target="_blank" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <!-- Services Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-subtitle">Services</h6>
                <ul class="footer-links">
                    <li><a href="services/consulting.php">Business Consulting</a></li>
                    <li><a href="services/support.php">Technical Support</a></li>
                    <li><a href="services/integration.php">System Integration</a></li>
                    <li><a href="services/cloud.php">Cloud Solutions</a></li>
                    <li><a href="services/security.php">Security Services</a></li>
                    <li><a href="services/training.php">Training & Support</a></li>
                </ul>
            </div>
            
            <!-- Industries Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-subtitle">Industries</h6>
                <ul class="footer-links">
                    <li><a href="industries/healthcare.php">Healthcare</a></li>
                    <li><a href="industries/finance.php">Finance & Banking</a></li>
                    <li><a href="industries/retail.php">Retail & E-commerce</a></li>
                    <li><a href="industries/manufacturing.php">Manufacturing</a></li>
                    <li><a href="industries/education.php">Education</a></li>
                    <li><a href="industries/government.php">Government</a></li>
                </ul>
            </div>
            
            <!-- Company Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-subtitle">Company</h6>
                <ul class="footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="careers.php">Careers</a></li>
                    <li><a href="news.php">News & Updates</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="partnerships.php">Partners</a></li>
                </ul>
            </div>
            
            <!-- Newsletter & Support -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-subtitle">Support</h6>
                <ul class="footer-links">
                    <li><a href="support/help.php">Help Center</a></li>
                    <li><a href="support/documentation.php">Documentation</a></li>
                    <li><a href="support/status.php">System Status</a></li>
                    <li><a href="support/tickets.php">Support Tickets</a></li>
                </ul>
                
                <!-- Newsletter Signup -->
                <div class="newsletter-signup mt-4">
                    <h6 class="footer-subtitle">Newsletter</h6>
                    <p class="small mb-2">Stay updated with our latest news</p>
                    <form class="newsletter-form" onsubmit="subscribeNewsletter(event)">
                        <div class="input-group input-group-sm">
                            <input type="email" class="form-control" placeholder="Your email" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <hr class="footer-divider mt-5">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="footer-copyright mb-0">
                    &copy; <?= date('Y') ?> ContinuServe. All rights reserved. | 
                    A subsidiary of Quattro Business Support Services
                </p>
            </div>
            <div class="col-md-6">
                <div class="footer-legal text-md-end">
                    <a href="legal/privacy.php" class="footer-link me-3">Privacy Policy</a>
                    <a href="legal/terms.php" class="footer-link me-3">Terms of Service</a>
                    <a href="legal/cookies.php" class="footer-link">Cookie Policy</a>
                </div>
            </div>
        </div>
        
        <!-- Website URL -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="footer-website mb-0">
                    <i class="fas fa-globe text-primary me-2"></i>
                    <a href="https://continuserve.com" class="text-primary">https://continuserve.com</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="btn-back-to-top" id="backToTop" title="Back to Top">
    <i class="fas fa-chevron-up"></i>
</button>