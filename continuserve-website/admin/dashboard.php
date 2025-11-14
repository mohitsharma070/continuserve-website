<?php
session_start();
require_once '../config/database.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Get dashboard statistics
$stats = getDashboardStats();

function getDashboardStats() {
    try {
        $pdo = getDbConnection();
        
        $stats = [];
        
        // Contact submissions
        $stmt = $pdo->query("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_count,
            SUM(CASE WHEN DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as week_count
            FROM contact_submissions");
        $stats['contacts'] = $stmt->fetch();
        
        // Newsletter subscriptions
        $stmt = $pdo->query("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_count,
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_count
            FROM newsletter_subscriptions");
        $stats['newsletter'] = $stmt->fetch();
        
        // Recent contacts
        $stmt = $pdo->query("SELECT * FROM contact_submissions 
                            ORDER BY created_at DESC LIMIT 5");
        $stats['recent_contacts'] = $stmt->fetchAll();
        
        // Popular subjects
        $stmt = $pdo->query("SELECT subject, COUNT(*) as count 
                            FROM contact_submissions 
                            GROUP BY subject 
                            ORDER BY count DESC LIMIT 5");
        $stats['popular_subjects'] = $stmt->fetchAll();
        
        return $stats;
        
    } catch (Exception $e) {
        error_log("Error getting dashboard stats: " . $e->getMessage());
        return [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ContinuServe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .main-content {
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="mb-4">
                        <i class="fas fa-shield-alt me-2"></i>
                        ContinuServe
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="contacts.php">
                            <i class="fas fa-envelope me-2"></i>Contact Submissions
                        </a>
                        <a class="nav-link" href="newsletter.php">
                            <i class="fas fa-newspaper me-2"></i>Newsletter
                        </a>
                        <a class="nav-link" href="analytics.php">
                            <i class="fas fa-chart-bar me-2"></i>Analytics
                        </a>
                        <a class="nav-link" href="settings.php">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                        <hr class="my-3">
                        <a class="nav-link" href="../index.php" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>View Website
                        </a>
                        <a class="nav-link" href="?logout=1" onclick="return confirm('Are you sure you want to logout?')">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-0">Dashboard</h1>
                            <p class="text-muted">Welcome back, <?= htmlspecialchars($_SESSION['admin_user']) ?>!</p>
                        </div>
                        <div>
                            <span class="badge bg-success">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Online
                            </span>
                        </div>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $stats['contacts']['total'] ?? 0 ?></h3>
                                        <p class="text-muted mb-0">Total Contacts</p>
                                        <?php if (($stats['contacts']['new_count'] ?? 0) > 0): ?>
                                        <small class="badge bg-warning">
                                            <?= $stats['contacts']['new_count'] ?> new
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success me-3">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $stats['newsletter']['active_count'] ?? 0 ?></h3>
                                        <p class="text-muted mb-0">Newsletter Subscribers</p>
                                        <?php if (($stats['newsletter']['today_count'] ?? 0) > 0): ?>
                                        <small class="badge bg-success">
                                            +<?= $stats['newsletter']['today_count'] ?> today
                                        </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-info me-3">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $stats['contacts']['today_count'] ?? 0 ?></h3>
                                        <p class="text-muted mb-0">Today's Contacts</p>
                                        <small class="text-info">
                                            <?= $stats['contacts']['week_count'] ?? 0 ?> this week
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning me-3">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0">
                                            <?php 
                                            $conversion = $stats['newsletter']['total'] > 0 ? 
                                                round(($stats['newsletter']['active_count'] / $stats['contacts']['total']) * 100, 1) : 0;
                                            echo $conversion;
                                            ?>%
                                        </h3>
                                        <p class="text-muted mb-0">Conversion Rate</p>
                                        <small class="text-warning">Contact to Newsletter</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Recent Contacts -->
                        <div class="col-lg-8">
                            <div class="table-card">
                                <div class="card-header bg-transparent border-0 pt-4 px-4">
                                    <h5 class="mb-0">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        Recent Contact Submissions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($stats['recent_contacts'])): ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                        <p>No contact submissions yet</p>
                                    </div>
                                    <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stats['recent_contacts'] as $contact): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($contact['name']) ?></td>
                                                    <td>
                                                        <small><?= htmlspecialchars($contact['email']) ?></small>
                                                    </td>
                                                    <td><?= htmlspecialchars($contact['subject']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $contact['status'] === 'new' ? 'primary' : 'success' ?>">
                                                            <?= ucfirst($contact['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small><?= date('M j, g:i A', strtotime($contact['created_at'])) ?></small>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="text-center pt-3">
                                        <a href="contacts.php" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-2"></i>View All Contacts
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Popular Subjects -->
                        <div class="col-lg-4">
                            <div class="table-card">
                                <div class="card-header bg-transparent border-0 pt-4 px-4">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-pie me-2 text-success"></i>
                                        Popular Subjects
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($stats['popular_subjects'])): ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-chart-pie fa-2x mb-3 opacity-50"></i>
                                        <p>No data available</p>
                                    </div>
                                    <?php else: ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($stats['popular_subjects'] as $subject): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            <span><?= htmlspecialchars($subject['subject']) ?></span>
                                            <span class="badge bg-primary rounded-pill"><?= $subject['count'] ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="table-card mt-4">
                                <div class="card-header bg-transparent border-0 pt-4 px-4">
                                    <h5 class="mb-0">
                                        <i class="fas fa-bolt me-2 text-warning"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="contacts.php?status=new" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-envelope me-2"></i>New Messages
                                        </a>
                                        <a href="newsletter.php" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-paper-plane me-2"></i>Send Newsletter
                                        </a>
                                        <a href="analytics.php" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-chart-bar me-2"></i>View Analytics
                                        </a>
                                        <a href="settings.php" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-cog me-2"></i>Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto refresh dashboard every 5 minutes
        setTimeout(function() {
            window.location.reload();
        }, 300000);
        
        // Show loading state on navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (!this.href.includes('#') && !this.href.includes('logout')) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                }
            });
        });
    </script>
</body>
</html>