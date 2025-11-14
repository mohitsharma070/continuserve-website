# ContinuServe Website

A professional PHP-based website for ContinuServe business support services, featuring modern design, responsive layout, contact management, and admin panel.

## 🌟 Features

- **Modern Responsive Design** - Mobile-first approach with Bootstrap 5
- **Contact Management** - Full form validation, database storage, email notifications
- **Newsletter System** - Subscription management with confirmation emails
- **Admin Panel** - Dashboard, contact management, analytics
- **Dynamic Content** - PHP-driven services grid and navigation
- **Security** - Input sanitization, rate limiting, SQL injection protection
- **Performance** - Optimized CSS/JS, image optimization, caching ready

## 📁 Project Structure

```
continuserve-website/
├── index.php                 # Main homepage
├── .env.example              # Environment configuration template
├── includes/                 # Reusable PHP components
│   ├── header.php           # Site header and navigation
│   ├── footer.php           # Site footer
│   ├── contact-form.php     # Contact form with validation
│   └── services-grid.php    # Services display grid
├── assets/                   # Static assets
│   ├── css/
│   │   └── style.css        # Main stylesheet
│   ├── js/
│   │   └── script.js        # Main JavaScript
│   └── images/              # Image assets
├── config/                   # Configuration files
│   └── database.php         # Database configuration and utilities
├── admin/                    # Admin panel
│   ├── login.php            # Admin login
│   ├── dashboard.php        # Admin dashboard
│   └── [other admin files]
└── api/                      # API endpoints
    └── newsletter.php       # Newsletter subscription API
```

## 🚀 Quick Setup

### 1. Prerequisites

- PHP 7.4+ (PHP 8+ recommended)
- MySQL 5.7+ / MariaDB 10.2+
- Web server (Apache/Nginx)
- Composer (optional, for dependencies)

### 2. Installation

1. **Clone/Download** the project to your web directory:
   ```bash
   # If using Git
   git clone <repository-url> continuserve-website
   cd continuserve-website
   
   # Or extract the ZIP file to your web directory
   ```

2. **Configure Environment**:
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` file with your settings:
   ```env
   DB_HOST=localhost
   DB_NAME=continuserve_db
   DB_USER=your_username
   DB_PASS=your_password
   ```

3. **Create Database**:
   ```sql
   CREATE DATABASE continuserve_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Initialize Database**:
   - Visit your website URL
   - Database tables will be created automatically
   - Default admin user will be created

5. **Set Permissions** (if on Linux/macOS):
   ```bash
   chmod 755 .
   chmod 644 *.php
   chmod -R 755 assets/
   ```

### 3. Configuration

#### Database Setup
The database will be automatically initialized when you first visit the site. It creates these tables:
- `contact_submissions` - Contact form submissions
- `newsletter_subscriptions` - Newsletter subscribers  
- `admin_users` - Admin panel users
- `website_analytics` - Basic analytics (optional)

#### Email Configuration
Update `.env` for email functionality:
```env
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
CONTACT_EMAIL=info@continuserve.com
```

#### Admin Access
Default admin credentials:
- **Username**: `admin`
- **Password**: `admin123`

⚠️ **Change the default password immediately after first login!**

## 💻 Admin Panel

Access the admin panel at: `your-domain.com/admin/`

### Features:
- **Dashboard** - Overview statistics and recent activity
- **Contact Management** - View, respond to contact submissions
- **Newsletter** - Manage subscribers and send campaigns
- **Analytics** - Basic website analytics
- **Settings** - Configure website settings

## 🎨 Customization

### Styling
- Main styles: `assets/css/style.css`
- Colors defined in CSS variables (`:root`)
- Bootstrap 5 for responsive grid and components

### Content
- Homepage content: `index.php`
- Services: `includes/services-grid.php`
- Navigation: `includes/header.php`
- Footer: `includes/footer.php`

### Logo & Branding
- Update logo in `assets/images/`
- Modify brand text in `includes/header.php`
- Update CSS variables for colors

## 🔧 Development

### Local Development
1. Use PHP built-in server:
   ```bash
   php -S localhost:8000
   ```

2. Or configure Apache/Nginx virtual host

### Adding New Pages
1. Create PHP file in root directory
2. Include header/footer:
   ```php
   <?php include 'includes/header.php'; ?>
   <!-- Your content here -->
   <?php include 'includes/footer.php'; ?>
   ```

### Database Functions
Common database operations are in `config/database.php`:
```php
$pdo = getDbConnection();
$stats = getDatabaseStats();
initializeDatabase();
```

## 📧 Contact Form

The contact form includes:
- Client-side validation (JavaScript)
- Server-side validation (PHP)
- Email notifications
- Database storage
- Rate limiting protection

### Processing Flow:
1. User fills out form
2. JavaScript validates on submit
3. PHP processes and validates
4. Email notification sent
5. Data stored in database
6. Success/error message displayed

## 📮 Newsletter System

### Features:
- AJAX subscription
- Email confirmation
- Unsubscribe management
- Admin panel integration

### API Endpoint:
`POST /api/newsletter.php`
```json
{
  "email": "user@example.com",
  "name": "User Name"
}
```

## 🔒 Security Features

- **Input Sanitization** - All user input is sanitized
- **SQL Injection Protection** - Prepared statements
- **CSRF Protection** - Ready for token implementation
- **Rate Limiting** - Prevents form spam
- **XSS Prevention** - HTML escaping
- **Password Hashing** - Secure admin passwords

## 🎯 SEO & Performance

### SEO Features:
- Semantic HTML structure
- Meta tags and descriptions
- Structured data ready
- Clean URLs
- Mobile-first responsive design

### Performance:
- Optimized CSS/JS
- Image optimization ready
- Gzip compression ready
- Browser caching headers ready

## 🚀 Production Deployment

### Checklist:
1. **Change default admin password**
2. **Update .env for production**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```
3. **Configure SSL certificate**
4. **Set up email service** (SMTP)
5. **Configure backups**
6. **Set up monitoring**
7. **Update contact information**
8. **Test all forms and functionality**

### Server Requirements:
- PHP 7.4+ with PDO MySQL extension
- MySQL 5.7+ / MariaDB 10.2+
- mod_rewrite enabled (Apache)
- SSL certificate (recommended)
- Regular backup solution

## 🆘 Troubleshooting

### Common Issues:

**Database connection failed:**
- Check database credentials in `.env`
- Verify database server is running
- Ensure database exists

**Contact form not sending emails:**
- Check email configuration in `.env`
- Verify SMTP settings
- Check server mail logs

**Admin login not working:**
- Use default credentials: admin/admin123
- Check if admin user exists in database
- Reset password via database if needed

**Styling issues:**
- Clear browser cache
- Check CSS file path
- Verify Bootstrap CDN is loading

### Debug Mode:
Set in `.env`:
```env
APP_DEBUG=true
```

## 📞 Support

For questions or issues:
- Check the troubleshooting section
- Review error logs in server
- Contact: [your-support-email]

## 📄 License

This project is for ContinuServe website. All rights reserved.

---

**Built with ❤️ for ContinuServe - Professional Business Support Services**