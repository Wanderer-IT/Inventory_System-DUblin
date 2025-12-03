<?php
include 'database.php';

$feedback = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['customerName'];
  $email = $_POST['customerEmail'];
  $phone = $_POST['customerPhone'];

  $stmt = $conn->prepare("INSERT INTO customers (customerName, customerEmail, customerPhone) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $phone);

  if ($stmt->execute()) {
    $feedback = "<p class='success'>Customer added successfully!</p>";
  } else {
    $feedback = "<p class='error'>Error: " . $stmt->error . "</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Customer - My Sari-Sari Store</title>
  <link rel="stylesheet" href="add_customer.css">
</head>
<body>

<div class="container">
  <nav class="nav">
    <div class="nav-logo">
      <h1>My Sari-Sari Store</h1>
    </div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="product.php">Shop</a>
      <a href="checkout.php">Check Out</a>
    </div>
  </nav>

  <div class="form-wrapper">
    <h2>Add New Customer</h2>
    <?php echo $feedback; ?>
    <form method="POST" class="form">
      <label for="customerName">Name:</label>
      <input type="text" name="customerName" id="customerName" required>

      <label for="customerEmail">Email:</label>
      <input type="email" name="customerEmail" id="customerEmail" required>

      <label for="customerPhone">Phone:</label>
      <input type="text" name="customerPhone" id="customerPhone" required>

      <button type="submit" class="btn">Add Customer</button>
    </form>
  </div>
</div>

</body>
</html>
