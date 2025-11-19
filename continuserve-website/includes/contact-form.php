<?php
// Include database connection
include 'includes/db.php';

// Initialize message
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $message = $_POST['message'];

    // Prepare and execute query
    $sql = "INSERT INTO contacts (name, email, company, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $company, $message);

    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Thank you! Your message has been sent successfully.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Oops! Something went wrong. Please try again.</div>';
    }

    $stmt->close();
}
?>

<!-- Contact Form -->
<?php if($msg) echo $msg; ?>
<form action="" method="post">
    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
    </div>
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
    </div>
    <div class="mb-3">
        <input type="text" name="company" class="form-control" placeholder="Company Name" required>
    </div>
    <div class="mb-3">
        <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>

<script>
// Auto-hide alert after 5 seconds
setTimeout(function() {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        alertBox.style.transition = "opacity 0.5s ease";
        alertBox.style.opacity = "0";
        setTimeout(() => alertBox.remove(), 500);
    }
}, 5000);

// Scroll back to contact section after form submit
<?php if (!empty($msg)) : ?>
    document.addEventListener("DOMContentLoaded", function () {
        const contactSection = document.querySelector("#contact");
        if (contactSection) {
            contactSection.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    });
<?php endif; ?>
</script>
