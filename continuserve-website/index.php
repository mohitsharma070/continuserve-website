<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Tekstrafin - Finance & Technology Consulting</title>
<meta name="description" content="Professional finance and technology consulting services by Tekstrafin. Empowering businesses with strategic solutions and expert guidance." />
<meta name="keywords" content="finance consulting, IT consulting, fintech strategy, business growth, technology advisory" />

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link href="assets/css/style.css" rel="stylesheet" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />

<style>
body {
    font-family: 'Open Sans', sans-serif;
    padding-top: 76px;
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Section offset for fixed navbar */
#about, #services, #testimonials, #contact {
    padding-top: 80px;
    margin-top: -76px;
}

/* HERO */
.hero-section {
    position: relative;
    height: 90vh;
    min-height: 600px;
    background: url('assets/images/banner.jpg') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-overlay {
    width: 100%;
    height: 100%;
    background: linear-gradient(rgba(13,59,102,0.7), rgba(13,59,102,0.85));
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 15px;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-size: 3rem;
    font-weight: 700;
    color: #FAF0CA;
    margin-bottom: 0.5rem;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: #F4D35E;
    margin-bottom: 1.5rem;
}

.hero-buttons .btn {
    padding: 12px 28px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #0D3B66;
    border-color: #0D3B66;
}

.btn-primary:hover {
    background-color: #F4D35E;
    border-color: #F4D35E;
    color: #000;
}

.btn-outline-light {
    border-color: #F4D35E;
    color: #FAF0CA;
}

.btn-outline-light:hover {
    background-color: #F4D35E;
    color: #000;
}

/* Sections */
.section-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.3rem;
    font-weight: 700;
    color: #0D3B66;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #555;
    margin-bottom: 1rem;
}

.title-underline {
    width: 80px;
    height: 4px;
    background: #F4D35E;
    margin: 0 auto 1.5rem;
    border-radius: 5px;
}

/* SERVICES */
.service-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    text-align: center;
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    background: #fff;
}
.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 18px 30px rgba(0,0,0,0.12);
}

/* ABOUT IMAGE */
.about-image-wrapper img {
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 100%;
}

/* TESTIMONIALS */
.testimonial-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.testimonial-card:hover {
    transform: translateY(-6px);
}
.testimonial-stars i {
    color: #F4D35E;
    font-size: 1.2rem;
}

/* CONTACT */
.contact-section {
    background: linear-gradient(135deg, #0D3B66, #003E99);
    color: #fff;
}
.contact-section .section-title, .contact-section .section-subtitle {
    color: #fff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .hero-title { font-size: 2rem; }
    .hero-subtitle { font-size: 1rem; }
    .hero-buttons .btn { width: 100%; margin-bottom: 10px; }
}
</style>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="76" tabindex="0">

<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero-section">
    <div class="hero-overlay" data-aos="fade-up">
        <div class="container">
            <h1 class="hero-title">Professional Finance & Technology Consulting</h1>
            <p class="hero-subtitle">Empowering your business with strategic solutions to drive growth and innovation</p>
            <div class="hero-buttons">
                <a href="#services" class="btn btn-primary btn-lg me-3"><i class="fas fa-rocket me-2"></i>Our Services</a>
                <a href="#contact" class="btn btn-outline-light btn-lg"><i class="fas fa-phone me-2"></i>Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services" class="py-5">
    <div class="container">
        <div class="text-center mb-5" style="margin-top:50px;" data-aos="fade-up">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Tailored solutions for finance, technology, and business growth</p>
            <div class="title-underline"></div>
        </div>
        <div class="row g-4">
            <?php include 'includes/services-grid.php'; ?>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="about-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3 class="section-title">About Tekstrafin</h3>
                <p class="lead text-primary">Your trusted partner for finance and technology consulting</p>
                <p>We deliver innovative solutions to optimize operations, enhance productivity, and achieve sustainable business growth.</p>
                <div class="row mt-4 text-center">
                    <div class="col-md-6">
                        <h4 class="stat-number text-primary">150+</h4>
                        <p class="stat-label">Happy Clients</p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="stat-number text-primary">500+</h4>
                        <p class="stat-label">Projects Completed</p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="about.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Learn More</a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-image-wrapper">
                    <img src="assets/images/team.jpg" alt="About Tekstrafin">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials" class="testimonials-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Hear from businesses that have benefited from Tekstrafin</p>
            <div class="title-underline"></div>
        </div>
        <div class="row g-4">
            <?php include 'includes/testimonials-grid.php'; ?>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="contact-section py-5">
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
        echo '<div class="alert alert-success text-center">Thank you! Your message has been sent successfully.</div>';
    }
    if (isset($_GET['msg']) && $_GET['msg'] === 'error') {
        echo '<div class="alert alert-danger text-center">Oops! Something went wrong. Please try again.</div>';
    }
    ?>

    <div class="container">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="section-title">Contact Us</h2>
            <p class="section-subtitle">Get in touch with our experts to discuss your business needs</p>
            <div class="title-underline bg-white"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <?php include 'includes/contact-form.php'; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });
</script>

</body>
</html>
