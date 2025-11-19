<?php
// testimonials-grid.php - Tekstrafin Testimonials from database

$servername = "localhost";
$username = "root";
$password = ""; // your XAMPP MySQL password, usually empty
$dbname = "tekstrafin_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch testimonials
$sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="testimonial-card">
                    <div class="testimonial-stars mb-2">';
        for ($i = 0; $i < $row['rating']; $i++) {
            echo '<i class="fas fa-star"></i>';
        }
        echo    '</div>
                    <p class="testimonial-text">"' . htmlspecialchars($row['message']) . '"</p>
                    <div class="testimonial-author">
                        <strong>' . htmlspecialchars($row['name']) . '</strong><br>
                        <span>' . htmlspecialchars($row['company']) . '</span>
                    </div>
                </div>
              </div>';
    }
} else {
    echo "<p class='text-center'>No testimonials available yet.</p>";
}

$conn->close();
?>
