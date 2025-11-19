<?php
// services-grid.php - Tekstrafin Services

$servername = "localhost";
$username = "root";
$password = ""; // your XAMPP MySQL password
$dbname = "tekstrafin_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch services
$sql = "SELECT * FROM services ORDER BY id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="'.htmlspecialchars($row['icon']).' fa-2x text-primary"></i>
                    </div>
                    <h4 class="mb-3">'.htmlspecialchars($row['title']).'</h4>
                    <p>'.htmlspecialchars($row['description']).'</p>
                </div>
              </div>';
    }
} else {
    echo "<p class='text-center'>No services available yet.</p>";
}

$conn->close();
?>

