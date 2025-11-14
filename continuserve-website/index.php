<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContinuServe - Business Support Services</title>
    <meta name="description" content="Professional business support services by ContinuServe, a subsidiary of Quattro Business Support Services.">
    <meta name="keywords" content="business support, consulting, technical support, system integration, cloud solutions">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="hero-title">Professional Business Support Services</h1>
                        <p class="hero-subtitle">Empowering your business with comprehensive solutions and expert support to drive growth and innovation</p>
                        <div class="hero-buttons">
                            <a href="#services" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-rocket me-2"></i>Our Services
                            </a>
                            <a href="#contact" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-phone me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Our Services</h2>
                    <p class="section-subtitle">Comprehensive business solutions tailored to your unique needs and objectives</p>
                    <div class="title-underline"></div>
                </div>
            </div>
            <div class="row g-4">
                <?php include 'includes/services-grid.php'; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="section-title">About ContinuServe</h3>
                    <p class="lead">A trusted subsidiary of Quattro Business Support Services</p>
                    <p>We specialize in delivering exceptional business support services that help organizations optimize their operations, enhance productivity, and achieve sustainable growth. Our team of experienced professionals brings deep industry knowledge and innovative solutions to every client engagement.</p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="stat-item">
                                <h4 class="stat-number">150+</h4>
                                <p class="stat-label">Happy Clients</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-item">
                                <h4 class="stat-number">500+</h4>
                                <p class="stat-label">Projects Completed</p>
                            </div>
                        </div>
                    </div>
                    <a href="about.php" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-right me-2"></i>Learn More
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="about-image-wrapper">
                        <img src="assets/images/about-team.jpg" alt="ContinuServe Team" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title text-white">Contact Us</h2>
                    <p class="section-subtitle text-white-50">Get in touch with our team of experts to discuss your business needs</p>
                    <div class="title-underline"></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php include 'includes/contact-form.php'; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Testimonials -->
    <section class="testimonials-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">What Our Clients Say</h2>
                    <p class="section-subtitle">Hear from businesses that have transformed with our support</p>
                    <div class="title-underline"></div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"ContinuServe transformed our business operations completely. Their expertise and support made all the difference."</p>
                        <div class="testimonial-author">
                            <strong>Sarah Johnson</strong>
                            <span>CEO, TechCorp Solutions</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Professional, reliable, and results-driven. I highly recommend ContinuServe for any business looking to scale."</p>
                        <div class="testimonial-author">
                            <strong>Michael Chen</strong>
                            <span>Director, Global Innovations</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Their technical support team is outstanding. Quick response times and effective solutions every time."</p>
                        <div class="testimonial-author">
                            <strong>Emily Rodriguez</strong>
                            <span>IT Manager, DataFlow Inc</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>