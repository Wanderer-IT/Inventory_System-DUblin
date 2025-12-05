<?php
include 'database.php';

$feedback = "";

// Handle photo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['costumerPhoto'])) {
  $uploadDir = 'uploads/';
  $fileName = basename($_FILES['costumerPhoto']['name']);
  $targetPath = $uploadDir . $fileName;

  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  if (move_uploaded_file($_FILES['costumerPhoto']['tmp_name'], $targetPath)) {
    $newestQuery = $conn->query("SELECT costumerID FROM costumer ORDER BY costumerID DESC LIMIT 1");
    $newest = $newestQuery->fetch_assoc();
    $newestID = $newest['costumerID'];

    $stmt = $conn->prepare("UPDATE costumer SET costumerPhoto = ? WHERE costumerID = ?");
    $stmt->bind_param("si", $targetPath, $newestID);

    if ($stmt->execute()) {
      $feedback = "<p class='success'>Photo uploaded successfully for newest customer!</p>";
    } else {
      $feedback = "<p class='error'>Database update failed: " . $stmt->error . "</p>";
    }
  } else {
    $feedback = "<p class='error'>Failed to upload photo.</p>";
  }
}

// ✅ Fetch newest costumer info BEFORE closing PHP
$sql = "SELECT * FROM costumer ORDER BY costumerID DESC LIMIT 1";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Me - My Sari-Sari Store</title>
  <link rel="stylesheet" href="about.css">
</head>
<body>

<nav class="nav">
  <div class="nav-logo">
    <h1>My Sari-Sari Store</h1>
  </div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="product.php">Shop</a>
    <a href="checkout.php">Check Out</a>
    <a href="view_orders.php">View Orders</a>
    <a href="about.php">About Me</a>
  </div>
</nav>

<div class="container">
  <div class="form-wrapper">
    <h2>About Me</h2>
    <?php echo $feedback; ?>
    <div class="about-content">
      <img src="<?php echo $customer['costumerPhoto'] ?: 'default.jpg'; ?>" alt="My Photo" class="about-photo">
      <p>
        Name: <strong><?php echo $customer['costumerName']; ?></strong><br>
        Location: <strong><?php echo $customer['costumerAddress']; ?></strong><br>
        Email: <strong><?php echo $customer['costumerEmail']; ?></strong><br>
        Phone Number: <strong><?php echo $customer['costumerPhonenumber']; ?></strong>
      </p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="form">
      <label for="costumerPhoto">Upload New Photo:</label>
      <input type="file" name="costumerPhoto" id="costumerPhoto" accept="image/*" required>
      <button type="submit" class="btn">Upload Photo</button>
    </form>
  </div>
</div>

</body>
</html>
