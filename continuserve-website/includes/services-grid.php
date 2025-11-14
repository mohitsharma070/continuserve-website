<?php
$services = [
    [
        'icon' => 'fas fa-chart-line',
        'title' => 'Business Consulting',
        'description' => 'Strategic guidance to optimize your business operations, enhance productivity, and drive sustainable growth through expert analysis and recommendations.',
        'features' => ['Strategic Planning', 'Process Optimization', 'Performance Analysis', 'Market Research'],
        'link' => 'services/consulting.php',
        'color' => 'primary'
    ],
    [
        'icon' => 'fas fa-headset',
        'title' => 'Technical Support',
        'description' => '24/7 technical assistance to keep your systems running smoothly with rapid response times and expert troubleshooting capabilities.',
        'features' => ['24/7 Support', 'System Monitoring', 'Issue Resolution', 'Preventive Maintenance'],
        'link' => 'services/support.php',
        'color' => 'success'
    ],
    [
        'icon' => 'fas fa-network-wired',
        'title' => 'System Integration',
        'description' => 'Seamlessly connect your business systems and applications for improved efficiency, data flow, and operational excellence.',
        'features' => ['API Development', 'Data Migration', 'Workflow Automation', 'Legacy System Integration'],
        'link' => 'services/integration.php',
        'color' => 'info'
    ],
    [
        'icon' => 'fas fa-cloud',
        'title' => 'Cloud Solutions',
        'description' => 'Migrate to the cloud with confidence and scalability while ensuring security, performance, and cost optimization.',
        'features' => ['Cloud Migration', 'Infrastructure Setup', 'Security & Compliance', 'Cost Optimization'],
        'link' => 'services/cloud.php',
        'color' => 'warning'
    ],
    [
        'icon' => 'fas fa-shield-alt',
        'title' => 'Security Services',
        'description' => 'Protect your business with comprehensive security solutions, risk assessments, and compliance management.',
        'features' => ['Security Audits', 'Risk Assessment', 'Compliance Management', 'Incident Response'],
        'link' => 'services/security.php',
        'color' => 'danger'
    ],
    [
        'icon' => 'fas fa-graduation-cap',
        'title' => 'Training & Support',
        'description' => 'Empower your team with expert training, comprehensive documentation, and ongoing support for maximum productivity.',
        'features' => ['Staff Training', 'Documentation', 'Ongoing Support', 'Knowledge Transfer'],
        'link' => 'services/training.php',
        'color' => 'secondary'
    ]
];

foreach ($services as $index => $service): ?>
<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
    <div class="service-card h-100">
        <div class="service-header">
            <div class="service-icon bg-<?= $service['color'] ?>">
                <i class="<?= $service['icon'] ?>"></i>
            </div>
            <h4 class="service-title"><?= $service['title'] ?></h4>
        </div>
        
        <div class="service-content">
            <p class="service-description"><?= $service['description'] ?></p>
            
            <ul class="service-features">
                <?php foreach ($service['features'] as $feature): ?>
                <li>
                    <i class="fas fa-check text-<?= $service['color'] ?> me-2"></i>
                    <?= $feature ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="service-footer">
            <a href="<?= $service['link'] ?>" class="btn btn-outline-<?= $service['color'] ?> w-100">
                <i class="fas fa-arrow-right me-2"></i>Learn More
            </a>
        </div>
        
        <!-- Service Badge -->
        <div class="service-badge">
            <span class="badge bg-<?= $service['color'] ?>"><?= strtoupper(explode(' ', $service['title'])[0]) ?></span>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Call to Action Card -->
<div class="col-12 mt-4">
    <div class="cta-card text-center">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="cta-title">Need a Custom Solution?</h4>
                <p class="cta-description mb-0">
                    Our team can create tailored solutions that meet your specific business requirements. 
                    Let's discuss your unique challenges and goals.
                </p>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <a href="#contact" class="btn btn-primary btn-lg">
                    <i class="fas fa-comments me-2"></i>Get Custom Quote
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Service Categories -->
<div class="col-12 mt-5">
    <div class="service-categories">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="category-item">
                    <i class="fas fa-cogs fa-2x text-primary mb-3"></i>
                    <h6>Automation</h6>
                    <p class="small text-muted">Streamline your processes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item">
                    <i class="fas fa-analytics fa-2x text-success mb-3"></i>
                    <h6>Analytics</h6>
                    <p class="small text-muted">Data-driven insights</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item">
                    <i class="fas fa-mobile-alt fa-2x text-info mb-3"></i>
                    <h6>Mobility</h6>
                    <p class="small text-muted">Mobile-first solutions</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item">
                    <i class="fas fa-users fa-2x text-warning mb-3"></i>
                    <h6>Collaboration</h6>
                    <p class="small text-muted">Team productivity tools</p>
                </div>
            </div>
        </div>
    </div>
</div>