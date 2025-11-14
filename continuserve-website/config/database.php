<?php
/**
 * Database Configuration for ContinuServe Website
 * 
 * This file contains database connection settings and utility functions
 * for the ContinuServe PHP website.
 */

// ===== DATABASE CONFIGURATION =====
class DatabaseConfig {
    // Database connection parameters
    private static $config = [
        'host' => 'localhost',
        'dbname' => 'continuserve_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
        ]
    ];
    
    private static $connection = null;
    
    /**
     * Get database configuration from environment or defaults
     */
    public static function getConfig() {
        return [
            'host' => $_ENV['DB_HOST'] ?? self::$config['host'],
            'dbname' => $_ENV['DB_NAME'] ?? self::$config['dbname'],
            'username' => $_ENV['DB_USER'] ?? self::$config['username'],
            'password' => $_ENV['DB_PASS'] ?? self::$config['password'],
            'charset' => $_ENV['DB_CHARSET'] ?? self::$config['charset'],
            'options' => self::$config['options']
        ];
    }
    
    /**
     * Create a new PDO connection
     */
    public static function createConnection() {
        $config = self::getConfig();
        
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        
        return new PDO($dsn, $config['username'], $config['password'], $config['options']);
    }
    
    /**
     * Get singleton database connection
     */
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = self::createConnection();
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new Exception("Database connection failed. Please try again later.");
            }
        }
        
        return self::$connection;
    }
}

/**
 * Get database connection (convenience function)
 */
function getDbConnection() {
    return DatabaseConfig::getConnection();
}

/**
 * Initialize database tables
 */
function initializeDatabase() {
    try {
        $pdo = getDbConnection();
        
        // Contact submissions table
        $contactSubmissionsTable = "
        CREATE TABLE IF NOT EXISTS contact_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            company VARCHAR(255) DEFAULT NULL,
            phone VARCHAR(50) DEFAULT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            newsletter_signup TINYINT(1) DEFAULT 0,
            status ENUM('new', 'read', 'responded', 'closed') DEFAULT 'new',
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_email (email),
            INDEX idx_status (status),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        // Newsletter subscriptions table
        $newsletterTable = "
        CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            name VARCHAR(255) DEFAULT NULL,
            status ENUM('active', 'unsubscribed', 'bounced') DEFAULT 'active',
            subscription_source VARCHAR(100) DEFAULT 'website',
            ip_address VARCHAR(45) DEFAULT NULL,
            confirmation_token VARCHAR(255) DEFAULT NULL,
            confirmed_at TIMESTAMP NULL,
            unsubscribed_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_email (email),
            INDEX idx_status (status),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        // Admin users table
        $adminUsersTable = "
        CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) UNIQUE NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            first_name VARCHAR(100) DEFAULT NULL,
            last_name VARCHAR(100) DEFAULT NULL,
            role ENUM('admin', 'manager', 'viewer') DEFAULT 'viewer',
            is_active TINYINT(1) DEFAULT 1,
            last_login TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_username (username),
            INDEX idx_email (email),
            INDEX idx_role (role)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        // Website analytics table
        $analyticsTable = "
        CREATE TABLE IF NOT EXISTS website_analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page_url VARCHAR(500) NOT NULL,
            page_title VARCHAR(255) DEFAULT NULL,
            visitor_ip VARCHAR(45) DEFAULT NULL,
            user_agent TEXT DEFAULT NULL,
            referrer VARCHAR(500) DEFAULT NULL,
            session_id VARCHAR(255) DEFAULT NULL,
            visit_duration INT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            INDEX idx_page_url (page_url(255)),
            INDEX idx_visitor_ip (visitor_ip),
            INDEX idx_created_at (created_at),
            INDEX idx_session_id (session_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        // Execute table creation
        $pdo->exec($contactSubmissionsTable);
        $pdo->exec($newsletterTable);
        $pdo->exec($adminUsersTable);
        $pdo->exec($analyticsTable);
        
        // Create default admin user if none exists
        createDefaultAdminUser($pdo);
        
        return true;
        
    } catch (PDOException $e) {
        error_log("Database initialization failed: " . $e->getMessage());
        throw new Exception("Database initialization failed: " . $e->getMessage());
    }
}

/**
 * Create default admin user
 */
function createDefaultAdminUser($pdo) {
    try {
        // Check if any admin users exist
        $stmt = $pdo->query("SELECT COUNT(*) FROM admin_users");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Create default admin user
            $defaultPassword = 'admin123'; // Change this in production!
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("
                INSERT INTO admin_users (username, email, password_hash, first_name, last_name, role) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                'admin',
                'admin@continuserve.com',
                $hashedPassword,
                'System',
                'Administrator',
                'admin'
            ]);
            
            error_log("Default admin user created: admin / admin123");
        }
        
    } catch (PDOException $e) {
        error_log("Error creating default admin user: " . $e->getMessage());
    }
}

/**
 * Test database connection
 */
function testDatabaseConnection() {
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->query("SELECT 1");
        return $stmt !== false;
    } catch (Exception $e) {
        error_log("Database connection test failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Get database statistics
 */
function getDatabaseStats() {
    try {
        $pdo = getDbConnection();
        
        $stats = [];
        
        // Contact submissions count
        $stmt = $pdo->query("SELECT COUNT(*) as count, status FROM contact_submissions GROUP BY status");
        $stats['contacts'] = $stmt->fetchAll();
        
        // Newsletter subscribers count
        $stmt = $pdo->query("SELECT COUNT(*) as total, 
                            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active 
                            FROM newsletter_subscriptions");
        $stats['newsletter'] = $stmt->fetch();
        
        // Recent activity
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_submissions 
                            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stats['recent_contacts'] = $stmt->fetchColumn();
        
        return $stats;
        
    } catch (Exception $e) {
        error_log("Error getting database stats: " . $e->getMessage());
        return [];
    }
}

/**
 * Clean old records (maintenance function)
 */
function cleanOldRecords() {
    try {
        $pdo = getDbConnection();
        
        // Delete old analytics records (older than 1 year)
        $pdo->exec("DELETE FROM website_analytics WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR)");
        
        // Delete unconfirmed newsletter subscriptions (older than 30 days)
        $pdo->exec("DELETE FROM newsletter_subscriptions 
                   WHERE confirmed_at IS NULL AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
        
        return true;
        
    } catch (Exception $e) {
        error_log("Error cleaning old records: " . $e->getMessage());
        return false;
    }
}

/**
 * Backup database (simple backup function)
 */
function backupDatabase($outputFile = null) {
    try {
        $config = DatabaseConfig::getConfig();
        
        if ($outputFile === null) {
            $outputFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        }
        
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            escapeshellarg($config['host']),
            escapeshellarg($config['username']),
            escapeshellarg($config['password']),
            escapeshellarg($config['dbname']),
            escapeshellarg($outputFile)
        );
        
        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);
        
        return $returnVar === 0;
        
    } catch (Exception $e) {
        error_log("Database backup failed: " . $e->getMessage());
        return false;
    }
}

// ===== SECURITY FUNCTIONS =====

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

/**
 * Validate email address
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Get client IP address
 */
function getClientIpAddress() {
    $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 
               'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 
               'REMOTE_ADDR'];
    
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            $ip = $_SERVER[$key];
            if (strpos($ip, ',') !== false) {
                $ip = explode(',', $ip)[0];
            }
            $ip = trim($ip);
            
            if (filter_var($ip, FILTER_VALIDATE_IP, 
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                return $ip;
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

/**
 * Rate limiting function
 */
function checkRateLimit($identifier, $maxRequests = 5, $timeWindow = 300) {
    try {
        $pdo = getDbConnection();
        
        // Clean old records
        $pdo->exec("DELETE FROM rate_limits WHERE created_at < DATE_SUB(NOW(), INTERVAL {$timeWindow} SECOND)");
        
        // Check current count
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rate_limits WHERE identifier = ? AND created_at > DATE_SUB(NOW(), INTERVAL {$timeWindow} SECOND)");
        $stmt->execute([$identifier]);
        $count = $stmt->fetchColumn();
        
        if ($count >= $maxRequests) {
            return false;
        }
        
        // Add current request
        $stmt = $pdo->prepare("INSERT INTO rate_limits (identifier, created_at) VALUES (?, NOW())");
        $stmt->execute([$identifier]);
        
        return true;
        
    } catch (Exception $e) {
        error_log("Rate limit check failed: " . $e->getMessage());
        return true; // Allow request if rate limiting fails
    }
}

// ===== INITIALIZATION =====

// Auto-initialize database if it's the first run
if (!testDatabaseConnection()) {
    try {
        initializeDatabase();
    } catch (Exception $e) {
        error_log("Auto database initialization failed: " . $e->getMessage());
    }
}

// Set error reporting based on environment
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
?>