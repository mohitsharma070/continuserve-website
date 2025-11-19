<?php
// Database connection
$servername = "localhost";
$username = "root";  // your DB username
$password = "";      // your DB password
$dbname = "tekstrafin"; // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $company = $_POST['company'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO testimonials (name, company, message, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $company, $message, $rating);

    if ($stmt->execute()) {
        $success = "Testimonial added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Testimonial - Tekstrafin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Add Testimonial</h2>
    <?php if(!empty($success)) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
    <?php if(!empty($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Company</label>
            <input type="text" name="company" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select">
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Testimonial</button>
    </form>
</div>

</body>
</html>
