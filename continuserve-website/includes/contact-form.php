<?php
// Initialize variables
$message = '';
$messageType = '';
$formData = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $result = handleContactForm($_POST);
    $message = $result['message'];
    $messageType = $result['type'];
    
    // Keep form data if there was an error
    if ($messageType === 'error') {
        $formData = $_POST;
    } else {
        $formData = []; // Clear form on success
    }
}

function handleContactForm($data) {
    // Sanitize and validate input
    $name = htmlspecialchars(trim($data['name'] ?? ''));
    $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $company = htmlspecialchars(trim($data['company'] ?? ''));
    $phone = htmlspecialchars(trim($data['phone'] ?? ''));
    $subject = htmlspecialchars(trim($data['subject'] ?? ''));
    $message = htmlspecialchars(trim($data['message'] ?? ''));
    $newsletter = isset($data['newsletter']) ? 1 : 0;
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    if (!empty($errors)) {
        return [
            'type' => 'error',
            'message' => 'Please correct the following errors: ' . implode(', ', $errors)
        ];
    }
    
    // Try to save to database and send email
    try {
        // Include database configuration
        if (file_exists(__DIR__ . '/../config/database.php')) {
            require_once __DIR__ . '/../config/database.php';
            
            $pdo = getDbConnection();
            $stmt = $pdo->prepare("
                INSERT INTO contact_submissions (name, email, company, phone, subject, message, newsletter_signup, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([$name, $email, $company, $phone, $subject, $message, $newsletter]);
        }
        
        // Send notification email
        sendContactNotification($name, $email, $company, $phone, $subject, $message);
        
        return [
            'type' => 'success',
            'message' => 'Thank you for your message! Our team will get back to you within 24 hours.'
        ];
        
    } catch (Exception $e) {
        error_log("Contact form error: " . $e->getMessage());
        
        // Still try to send email even if database fails
        try {
            sendContactNotification($name, $email, $company, $phone, $subject, $message);
            return [
                'type' => 'success',
                'message' => 'Thank you for your message! Our team will get back to you soon.'
            ];
        } catch (Exception $emailError) {
            error_log("Email sending failed: " . $emailError->getMessage());
            return [
                'type' => 'error',
                'message' => 'There was an error sending your message. Please try again or contact us directly at info@continuserve.com'
            ];
        }
    }
}

function sendContactNotification($name, $email, $company, $phone, $subject, $message) {
    $to = "info@continuserve.com";
    $emailSubject = "New Contact Form Submission: " . $subject;
    
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background-color: #dc3545; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #555; }
            .value { margin-left: 10px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>New Contact Form Submission</h2>
        </div>
        <div class='content'>
            <div class='field'>
                <span class='label'>Name:</span>
                <span class='value'>{$name}</span>
            </div>
            <div class='field'>
                <span class='label'>Email:</span>
                <span class='value'>{$email}</span>
            </div>
            <div class='field'>
                <span class='label'>Company:</span>
                <span class='value'>{$company}</span>
            </div>
            <div class='field'>
                <span class='label'>Phone:</span>
                <span class='value'>{$phone}</span>
            </div>
            <div class='field'>
                <span class='label'>Subject:</span>
                <span class='value'>{$subject}</span>
            </div>
            <div class='field'>
                <span class='label'>Message:</span>
                <div class='value' style='background: #f8f9fa; padding: 15px; border-left: 4px solid #dc3545; margin-top: 10px;'>
                    {$message}
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: ContinuServe Website <noreply@continuserve.com>',
        "Reply-To: {$email}",
        'X-Mailer: PHP/' . phpversion()
    ];
    
    return mail($to, $emailSubject, $emailBody, implode("\r\n", $headers));
}
?>

<!-- Contact Form -->
<div class="contact-form-wrapper">
    <?php if ($message): ?>
    <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
        <?= $message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form method="POST" class="contact-form needs-validation" novalidate>
        <div class="row g-3">
            <!-- Name Field -->
            <div class="col-md-6">
                <label for="name" class="form-label">
                    <i class="fas fa-user text-primary me-2"></i>Full Name *
                </label>
                <input type="text" class="form-control" id="name" name="name" required 
                       value="<?= htmlspecialchars($formData['name'] ?? '') ?>"
                       placeholder="Enter your full name">
                <div class="invalid-feedback">
                    Please provide your full name.
                </div>
            </div>
            
            <!-- Email Field -->
            <div class="col-md-6">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope text-primary me-2"></i>Email Address *
                </label>
                <input type="email" class="form-control" id="email" name="email" required
                       value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                       placeholder="Enter your email address">
                <div class="invalid-feedback">
                    Please provide a valid email address.
                </div>
            </div>
            
            <!-- Company Field -->
            <div class="col-md-6">
                <label for="company" class="form-label">
                    <i class="fas fa-building text-primary me-2"></i>Company
                </label>
                <input type="text" class="form-control" id="company" name="company"
                       value="<?= htmlspecialchars($formData['company'] ?? '') ?>"
                       placeholder="Enter your company name">
            </div>
            
            <!-- Phone Field -->
            <div class="col-md-6">
                <label for="phone" class="form-label">
                    <i class="fas fa-phone text-primary me-2"></i>Phone Number
                </label>
                <input type="tel" class="form-control" id="phone" name="phone"
                       value="<?= htmlspecialchars($formData['phone'] ?? '') ?>"
                       placeholder="Enter your phone number">
            </div>
            
            <!-- Subject Field -->
            <div class="col-12">
                <label for="subject" class="form-label">
                    <i class="fas fa-tag text-primary me-2"></i>Subject *
                </label>
                <select class="form-select" id="subject" name="subject" required>
                    <option value="">Select a subject</option>
                    <option value="General Inquiry" <?= ($formData['subject'] ?? '') === 'General Inquiry' ? 'selected' : '' ?>>
                        General Inquiry
                    </option>
                    <option value="Business Consulting" <?= ($formData['subject'] ?? '') === 'Business Consulting' ? 'selected' : '' ?>>
                        Business Consulting
                    </option>
                    <option value="Technical Support" <?= ($formData['subject'] ?? '') === 'Technical Support' ? 'selected' : '' ?>>
                        Technical Support
                    </option>
                    <option value="System Integration" <?= ($formData['subject'] ?? '') === 'System Integration' ? 'selected' : '' ?>>
                        System Integration
                    </option>
                    <option value="Cloud Solutions" <?= ($formData['subject'] ?? '') === 'Cloud Solutions' ? 'selected' : '' ?>>
                        Cloud Solutions
                    </option>
                    <option value="Partnership" <?= ($formData['subject'] ?? '') === 'Partnership' ? 'selected' : '' ?>>
                        Partnership Opportunities
                    </option>
                    <option value="Other" <?= ($formData['subject'] ?? '') === 'Other' ? 'selected' : '' ?>>
                        Other
                    </option>
                </select>
                <div class="invalid-feedback">
                    Please select a subject.
                </div>
            </div>
            
            <!-- Message Field -->
            <div class="col-12">
                <label for="message" class="form-label">
                    <i class="fas fa-comment text-primary me-2"></i>Message *
                </label>
                <textarea class="form-control" id="message" name="message" rows="5" required
                          placeholder="Tell us about your project or how we can help you..."><?= htmlspecialchars($formData['message'] ?? '') ?></textarea>
                <div class="invalid-feedback">
                    Please provide a message.
                </div>
                <div class="form-text">
                    <small>Minimum 10 characters. Be specific about your needs for a better response.</small>
                </div>
            </div>
            
            <!-- Newsletter Checkbox -->
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" 
                           <?= isset($formData['newsletter']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="newsletter">
                        Subscribe to our newsletter for updates and industry insights
                    </label>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="col-12">
                <button type="submit" name="submit_contact" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-paper-plane me-2"></i>Send Message
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>
                <div class="form-text text-center mt-2">
                    <small>We typically respond within 24 hours</small>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Contact Info Cards -->
<div class="row g-4 mt-4">
    <div class="col-md-4">
        <div class="contact-info-card text-center">
            <div class="contact-icon">
                <i class="fas fa-phone"></i>
            </div>
            <h5>Call Us</h5>
            <p>+1 (555) 123-4567<br>
            <small class="text-muted">Mon-Fri 9AM-6PM EST</small></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="contact-info-card text-center">
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h5>Email Us</h5>
            <p>info@continuserve.com<br>
            <small class="text-muted">24/7 Support</small></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="contact-info-card text-center">
            <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h5>Visit Us</h5>
            <p>123 Business Ave, Suite 100<br>
            <small class="text-muted">New York, NY 10001</small></p>
        </div>
    </div>
</div>