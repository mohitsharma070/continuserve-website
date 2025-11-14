<header class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <div class="logo-container me-2">
                <div class="logo-square"></div>
            </div>
            <span class="brand-text">CONTINUSERVE</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">HOME</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        SERVICES
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="services/consulting.php">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Business Consulting
                        </a></li>
                        <li><a class="dropdown-item" href="services/support.php">
                            <i class="fas fa-headset me-2 text-primary"></i>Technical Support
                        </a></li>
                        <li><a class="dropdown-item" href="services/integration.php">
                            <i class="fas fa-network-wired me-2 text-primary"></i>System Integration
                        </a></li>
                        <li><a class="dropdown-item" href="services/cloud.php">
                            <i class="fas fa-cloud me-2 text-primary"></i>Cloud Solutions
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="services.php">
                            <i class="fas fa-th-large me-2 text-secondary"></i>All Services
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        PLATFORMS
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="platforms/cloud.php">
                            <i class="fas fa-server me-2 text-primary"></i>Cloud Platforms
                        </a></li>
                        <li><a class="dropdown-item" href="platforms/enterprise.php">
                            <i class="fas fa-building me-2 text-primary"></i>Enterprise Systems
                        </a></li>
                        <li><a class="dropdown-item" href="platforms/integration.php">
                            <i class="fas fa-plug me-2 text-primary"></i>Integration Tools
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        INDUSTRIES
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="industries/healthcare.php">
                            <i class="fas fa-heartbeat me-2 text-primary"></i>Healthcare
                        </a></li>
                        <li><a class="dropdown-item" href="industries/finance.php">
                            <i class="fas fa-university me-2 text-primary"></i>Finance & Banking
                        </a></li>
                        <li><a class="dropdown-item" href="industries/retail.php">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i>Retail & E-commerce
                        </a></li>
                        <li><a class="dropdown-item" href="industries/manufacturing.php">
                            <i class="fas fa-industry me-2 text-primary"></i>Manufacturing
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : '' ?>" href="about.php">ABOUT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'news.php' ? 'active' : '' ?>" href="news.php">NEWS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">CONTACT US</a>
                </li>
            </ul>
            
            <!-- Right side navigation -->
            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="setLanguage('en')">
                            <img src="assets/images/flags/us.png" width="16" class="me-2" alt="English">English
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="setLanguage('es')">
                            <img src="assets/images/flags/es.png" width="16" class="me-2" alt="Spanish">Español
                        </a></li>
                    </ul>
                </div>
                <a class="nav-link social-link" href="https://linkedin.com/company/continuserve" target="_blank" 
                   title="Follow us on LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#contact" class="btn btn-primary ms-2 d-none d-lg-block">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Contact Button -->
<div class="mobile-contact-btn d-lg-none">
    <a href="#contact" class="btn btn-primary btn-floating">
        <i class="fas fa-phone"></i>
    </a>
</div>