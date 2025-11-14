# ContinuServe Website - Quick Start Instructions

## Option 1: XAMPP Installation (Recommended)

### Download & Install:
1. Go to: https://www.apachefriends.org/download.html
2. Download XAMPP for Windows
3. Install with default settings
4. Start XAMPP Control Panel
5. Start Apache and MySQL services

### Setup Project:
1. Copy your project folder to: `C:\xampp\htdocs\`
2. Rename folder to: `continuserve-website`
3. Open browser and visit: http://localhost/continuserve-website

## Option 2: PHP Built-in Server

### Install PHP:
1. Download PHP from: https://windows.php.net/download/
2. Extract to: `C:\php`
3. Add `C:\php` to your Windows PATH

### Run Project:
1. Double-click `start-server.bat`
2. Visit: http://localhost:8000

## Database Setup

### For XAMPP:
1. Visit: http://localhost/phpmyadmin
2. Create database: `continuserve_db`
3. The website will auto-create tables on first visit

### For Standalone PHP:
You'll need to install MySQL separately or use SQLite.

## Configuration

1. Edit `.env` file with your settings:
   - Database credentials
   - Email settings (for contact form)
   - Other configurations

## Default Admin Access
- URL: http://localhost/continuserve-website/admin/
- Username: admin
- Password: admin123

**⚠️ Change the default password after first login!**

## Troubleshooting

### Common Issues:
- **Database connection error**: Check MySQL is running
- **Page not found**: Ensure correct URL path
- **PHP errors**: Check PHP error logs
- **Styling broken**: Clear browser cache

### Getting Help:
- Check the main README.md file
- Ensure all services are running
- Verify file permissions
- Check PHP and MySQL versions