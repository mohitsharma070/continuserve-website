# Add this to your database.php security functions
<?php
/**
 * Additional Security Functions for Production
 */

// CSRF Token Generation and Validation
function generateCSRFToken() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Rate Limiting
function checkRateLimit($identifier, $max_requests = 10, $time_window = 300) {
    $cache_file = "cache/rate_limit_" . md5($identifier) . ".tmp";
    $current_time = time();
    
    if (file_exists($cache_file)) {
        $data = json_decode(file_get_contents($cache_file), true);
        
        // Clean old entries
        $data['requests'] = array_filter($data['requests'], function($timestamp) use ($current_time, $time_window) {
            return ($current_time - $timestamp) <= $time_window;
        });
        
        if (count($data['requests']) >= $max_requests) {
            return false; // Rate limit exceeded
        }
        
        $data['requests'][] = $current_time;
    } else {
        $data = ['requests' => [$current_time]];
    }
    
    // Create cache directory if it doesn't exist
    if (!is_dir('cache')) {
        mkdir('cache', 0755, true);
    }
    
    file_put_contents($cache_file, json_encode($data));
    return true;
}

// IP-based rate limiting
function getRealIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Enhanced input validation
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/[<>"]/', $email);
}

function validatePhoneNumber($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    // Check if it's a valid length (7-15 digits)
    return strlen($phone) >= 7 && strlen($phone) <= 15;
}

// File upload security
function validateFileUpload($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    if ($file['size'] > $max_size) {
        return false;
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    return in_array($mime_type, $allowed_types);
}

// Log security events
function logSecurityEvent($event, $details = '') {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => getRealIPAddress(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'event' => $event,
        'details' => $details
    ];
    
    if (!is_dir('logs')) {
        mkdir('logs', 0755, true);
    }
    
    file_put_contents('logs/security.log', json_encode($log_entry) . "\n", FILE_APPEND | LOCK_EX);
}
?>