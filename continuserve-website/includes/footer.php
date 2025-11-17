<?php
// footer.php - Enhanced Tekstrafin Footer
?>

<footer style="background-color:#0D3B66; color:#FAF0CA; padding:60px 0; font-family:'Open Sans', sans-serif;">
    <div class="container">
        <div class="row">

            <!-- About / Brand -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 style="font-family:'Poppins', sans-serif; font-weight:700; color:#F4D35E;">Tekstrafin</h5>
                <p>Your trusted partner for business and technology consulting, empowering growth through innovative solutions and expert guidance.</p>
                <div class="footer-icons mt-3">
                    <a href="#" style="color:#FAF0CA; margin-right:10px; transition:0.3s;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="color:#FAF0CA; margin-right:10px; transition:0.3s;"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" style="color:#FAF0CA; margin-right:10px; transition:0.3s;"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="mailto:info@tekstrafin.com" style="color:#FAF0CA; transition:0.3s;"><i class="fa-solid fa-envelope"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 style="font-weight:700; color:#F4D35E;">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="index.php" style="color:#FAF0CA; text-decoration:none;">Home</a></li>
                    <li><a href="about.php" style="color:#FAF0CA; text-decoration:none;">About Us</a></li>
                    <li><a href="services.php" style="color:#FAF0CA; text-decoration:none;">Services</a></li>
                    <li><a href="case-studies.php" style="color:#FAF0CA; text-decoration:none;">Case Studies</a></li>
                    <li><a href="blog.php" style="color:#FAF0CA; text-decoration:none;">Blog</a></li>
                    <li><a href="#contact" style="color:#FAF0CA; text-decoration:none;">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 style="font-weight:700; color:#F4D35E;">Contact Us</h6>
                <p style="margin-bottom:5px;"><i class="fas fa-envelope me-2"></i> info@tekstrafin.com</p>
                <p style="margin-bottom:5px;"><i class="fas fa-phone me-2"></i> +91 9876543210</p>
                <p><i class="fas fa-map-marker-alt me-2"></i> Jaipur, Rajasthan, India</p>
            </div>

            <!-- Newsletter / CTA -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 style="font-weight:700; color:#F4D35E;">Newsletter</h6>
                <p>Subscribe to our newsletter for insights, updates, and business tips.</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email" aria-label="Email" style="border-radius:50px 0 0 50px; border:none; padding:10px;">
                        <button class="btn btn-warning" type="submit" style="border-radius:0 50px 50px 0; background-color:#F4D35E; color:#0D3B66; border:none;">Subscribe</button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4 pt-3 border-top" style="border-color:#FAF0CA;">
            <p style="margin-bottom:0;">© <?php echo date("Y"); ?> Tekstrafin. All rights reserved.</p>
        </div>
    </div>
</footer>
