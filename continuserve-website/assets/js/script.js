// ===== DOCUMENT READY ===== 
document.addEventListener('DOMContentLoaded', function() {
    initializeWebsite();
});

// ===== MAIN INITIALIZATION =====
function initializeWebsite() {
    initScrollEffects();
    initNavigation();
    initContactForm();
    initAnimations();
    initBackToTop();
    initNewsletterForm();
    initLanguageSelector();
    initMobileOptimizations();
}

// ===== SCROLL EFFECTS =====
function initScrollEffects() {
    const navbar = document.querySelector('.navbar');
    const backToTopBtn = document.getElementById('backToTop');
    
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            handleScroll(navbar, backToTopBtn);
        }, 10);
    });
    
    // Initial check
    handleScroll(navbar, backToTopBtn);
}

function handleScroll(navbar, backToTopBtn) {
    const scrollY = window.scrollY;
    
    // Navbar background change
    if (navbar) {
        if (scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    
    // Back to top button
    if (backToTopBtn) {
        if (scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    }
    
    // Removed parallax effect for hero section to prevent content overlap
}

// ===== NAVIGATION =====
function initNavigation() {
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                smoothScrollTo(href);
            }
        });
    });
    
    // Mobile menu close on link click
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
    
    // Highlight active section in navigation
    highlightActiveSection();
    window.addEventListener('scroll', highlightActiveSection);
}

function smoothScrollTo(target) {
    const element = document.querySelector(target);
    if (element) {
        const offsetTop = element.offsetTop - 80; // Account for fixed navbar
        window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
        });
        
        // Update URL without triggering scroll
        if (history.pushState) {
            history.pushState(null, null, target);
        }
    }
}

function highlightActiveSection() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
    
    let currentSection = '';
    const scrollPosition = window.scrollY + 100;
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            currentSection = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.classList.add('active');
        }
    });
}

// ===== CONTACT FORM =====
function initContactForm() {
    const contactForm = document.querySelector('.contact-form');
    if (!contactForm) return;
    
    // Form validation
    contactForm.addEventListener('submit', function(e) {
        if (!validateContactForm(this)) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            showFormSubmitting(this);
        }
        
        this.classList.add('was-validated');
    });
    
    // Real-time validation
    const formControls = contactForm.querySelectorAll('.form-control, .form-select');
    formControls.forEach(control => {
        control.addEventListener('blur', function() {
            validateField(this);
        });
        
        control.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
}

function validateContactForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Email validation
    const emailField = form.querySelector('[type="email"]');
    if (emailField && emailField.value && !isValidEmail(emailField.value)) {
        showFieldError(emailField, 'Please enter a valid email address');
        isValid = false;
    }
    
    // Message length validation
    const messageField = form.querySelector('#message');
    if (messageField && messageField.value.length < 10) {
        showFieldError(messageField, 'Message must be at least 10 characters long');
        isValid = false;
    }
    
    if (!isValid) {
        showAlert('Please correct the errors below before submitting.', 'danger');
        // Focus on first invalid field
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        isValid = false;
    }
    // Email validation
    else if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Please enter a valid email address');
        isValid = false;
    }
    // Phone validation (if value exists)
    else if (field.type === 'tel' && value && !isValidPhone(value)) {
        showFieldError(field, 'Please enter a valid phone number');
        isValid = false;
    }
    else {
        showFieldSuccess(field);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    field.classList.remove('is-valid');
    field.classList.add('is-invalid');
    
    let feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.textContent = message;
    }
}

function showFieldSuccess(field) {
    field.classList.remove('is-invalid');
    field.classList.add('is-valid');
}

function showFormSubmitting(form) {
    const submitBtn = form.querySelector('[type="submit"]');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    if (submitBtn) {
        submitBtn.disabled = true;
        if (spinner) {
            spinner.classList.remove('d-none');
        }
        
        // Reset after 5 seconds as fallback
        setTimeout(() => {
            submitBtn.disabled = false;
            if (spinner) {
                spinner.classList.add('d-none');
            }
        }, 5000);
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

// ===== ANIMATIONS =====
function initAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                element.classList.add('animate-fade-in');
                observer.unobserve(element);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll(
        '.service-card, .testimonial-card, .contact-info-card, .stat-item'
    );
    
    animateElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        observer.observe(element);
    });
    
    // Counter animation for stats
    initCounterAnimation();
}

function initCounterAnimation() {
    const counters = document.querySelectorAll('.stat-number');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
}

function animateCounter(element) {
    const target = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 2000; // 2 seconds
    const increment = target / (duration / 16); // 60 FPS
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = formatNumber(target) + (element.textContent.includes('+') ? '+' : '');
            clearInterval(timer);
        } else {
            element.textContent = formatNumber(Math.floor(current)) + (element.textContent.includes('+') ? '+' : '');
        }
    }, 16);
}

function formatNumber(num) {
    if (num >= 1000) {
        return (num / 1000).toFixed(0) + 'k';
    }
    return num.toString();
}

// ===== BACK TO TOP =====
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// ===== NEWSLETTER =====
function initNewsletterForm() {
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            if (emailInput && isValidEmail(emailInput.value)) {
                subscribeNewsletter(emailInput.value);
                emailInput.value = '';
            } else {
                showAlert('Please enter a valid email address', 'danger');
            }
        });
    });
}

function subscribeNewsletter(email) {
    // Show loading state
    showAlert('Subscribing...', 'info');
    
    // Simulate API call (replace with actual endpoint)
    fetch('api/newsletter.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Thank you for subscribing to our newsletter!', 'success');
        } else {
            showAlert(data.message || 'Error subscribing to newsletter', 'danger');
        }
    })
    .catch(error => {
        console.error('Newsletter subscription error:', error);
        showAlert('Thank you for your interest! We\'ll add you to our newsletter.', 'success');
    });
}

// ===== LANGUAGE SELECTOR =====
function initLanguageSelector() {
    const languageLinks = document.querySelectorAll('[onclick^="setLanguage"]');
    
    languageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const lang = this.onclick.toString().match(/setLanguage\('(.+?)'\)/)[1];
            setLanguage(lang);
        });
    });
}

function setLanguage(lang) {
    // Store language preference
    localStorage.setItem('preferredLanguage', lang);
    
    // Show notification
    const langName = lang === 'en' ? 'English' : 'Español';
    showAlert(`Language changed to ${langName}`, 'success');
    
    // In a real implementation, this would reload the page with the new language
    console.log('Language set to:', lang);
}

// ===== MOBILE OPTIMIZATIONS =====
function initMobileOptimizations() {
    // Prevent zoom on input focus for mobile
    if (window.innerWidth <= 768) {
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                document.querySelector('meta[name=viewport]').setAttribute(
                    'content', 
                    'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'
                );
            });
            
            input.addEventListener('blur', function() {
                document.querySelector('meta[name=viewport]').setAttribute(
                    'content', 
                    'width=device-width, initial-scale=1.0'
                );
            });
        });
    }
    
    // Mobile contact button
    const mobileContactBtn = document.querySelector('.mobile-contact-btn .btn');
    if (mobileContactBtn) {
        mobileContactBtn.addEventListener('click', function(e) {
            e.preventDefault();
            smoothScrollTo('#contact');
        });
    }
    
    // Touch events for service cards
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.classList.add('touch-active');
        });
        
        card.addEventListener('touchend', function() {
            this.classList.remove('touch-active');
        });
    });
}

// ===== UTILITY FUNCTIONS =====
function showAlert(message, type = 'info', duration = 5000) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-custom');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-custom`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    `;
    
    alertDiv.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after duration
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, duration);
}

function getAlertIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'danger': return 'exclamation-triangle';
        case 'warning': return 'exclamation-circle';
        case 'info': return 'info-circle';
        default: return 'info-circle';
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// ===== EXTERNAL API FUNCTIONS =====
// These functions can be called from HTML or other scripts

window.subscribeNewsletter = subscribeNewsletter;
window.setLanguage = setLanguage;
window.showAlert = showAlert;

// ===== PERFORMANCE OPTIMIZATIONS =====
// Optimize scroll events
window.addEventListener('scroll', throttle(function() {
    // Additional scroll-based effects can be added here
}, 16)); // ~60fps

// Preload critical resources
function preloadCriticalResources() {
    const criticalImages = [
        'assets/images/logo.png',
        'assets/images/about-team.jpg'
    ];
    
    criticalImages.forEach(src => {
        const img = new Image();
        img.src = src;
    });
}

// Call preload when DOM is ready
document.addEventListener('DOMContentLoaded', preloadCriticalResources);

// ===== ERROR HANDLING =====
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    // In production, you might want to send this to an error tracking service
});

// ===== ACCESSIBILITY IMPROVEMENTS =====
document.addEventListener('keydown', function(e) {
    // ESC key closes modals and dropdowns
    if (e.key === 'Escape') {
        const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
        openDropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }
    
    // Enter key on buttons
    if (e.key === 'Enter' && e.target.tagName === 'BUTTON') {
        e.target.click();
    }
});

// ===== PRINT STYLES =====
window.addEventListener('beforeprint', function() {
    document.body.classList.add('printing');
});

window.addEventListener('afterprint', function() {
    document.body.classList.remove('printing');
});

console.log('ContinuServe Website JavaScript initialized successfully!');