<?php
/**
 * Newsletter API Endpoint
 * Handles newsletter subscription requests
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once '../config/database.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['email'])) {
        throw new Exception('Email address is required');
    }
    
    $email = filter_var(trim($input['email']), FILTER_SANITIZE_EMAIL);
    $name = isset($input['name']) ? sanitizeInput($input['name']) : null;
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Please enter a valid email address');
    }
    
    // Rate limiting
    $clientIp = getClientIpAddress();
    if (!checkRateLimit($clientIp, 5, 300)) {
        throw new Exception('Too many requests. Please try again later.');
    }
    
    // Check if email already exists
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM newsletter_subscriptions WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        if ($existing['status'] === 'active') {
            echo json_encode([
                'success' => true,
                'message' => 'You are already subscribed to our newsletter!'
            ]);
            exit;
        } else {
            // Reactivate subscription
            $stmt = $pdo->prepare("
                UPDATE newsletter_subscriptions 
                SET status = 'active', updated_at = NOW(), unsubscribed_at = NULL 
                WHERE email = ?
            ");
            $stmt->execute([$email]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Welcome back! Your subscription has been reactivated.'
            ]);
            exit;
        }
    }
    
    // Create new subscription
    $confirmationToken = bin2hex(random_bytes(32));
    
    $stmt = $pdo->prepare("
        INSERT INTO newsletter_subscriptions 
        (email, name, confirmation_token, ip_address, subscription_source) 
        VALUES (?, ?, ?, ?, 'website')
    ");
    
    $stmt->execute([$email, $name, $confirmationToken, $clientIp]);
    
    // Send confirmation email (optional)
    if (function_exists('sendConfirmationEmail')) {
        sendConfirmationEmail($email, $name, $confirmationToken);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for subscribing! You\'ll receive updates about our latest news and services.'
    ]);
    
} catch (Exception $e) {
    error_log("Newsletter subscription error: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

/**
 * Send confirmation email (implement as needed)
 */
function sendConfirmationEmail($email, $name, $token) {
    try {
        $subject = "Confirm your newsletter subscription - ContinuServe";
        $confirmUrl = "https://continuserve.com/newsletter/confirm.php?token=" . $token;
        
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #dc3545, #b02a37); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: white; padding: 30px; border: 1px solid #ddd; }
                .button { background: #dc3545; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Welcome to ContinuServe Newsletter!</h2>
                </div>
                <div class='content'>
                    <h3>Hello" . ($name ? " " . htmlspecialchars($name) : "") . "!</h3>
                    <p>Thank you for subscribing to our newsletter. You'll receive updates about:</p>
                    <ul>
                        <li>Latest business solutions and services</li>
                        <li>Industry insights and trends</li>
                        <li>Company news and announcements</li>
                        <li>Special offers and promotions</li>
                    </ul>
                    <p>To complete your subscription, please click the button below:</p>
                    <a href='{$confirmUrl}' class='button'>Confirm Subscription</a>
                    <p>If the button doesn't work, copy and paste this link into your browser:</p>
                    <p><a href='{$confirmUrl}'>{$confirmUrl}</a></p>
                </div>
                <div class='footer'>
                    <p>ContinuServe - A subsidiary of Quattro Business Support Services</p>
                    <p>You can unsubscribe at any time by clicking the unsubscribe link in our emails.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ContinuServe Newsletter <newsletter@continuserve.com>',
            'Reply-To: info@continuserve.com',
            'X-Mailer: PHP/' . phpversion()
        ];
        
        return mail($email, $subject, $message, implode("\r\n", $headers));
        
    } catch (Exception $e) {
        error_log("Confirmation email failed: " . $e->getMessage());
        return false;
    }
}
?>