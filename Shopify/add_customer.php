<?php
include 'database.php';

$feedback = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['costumerName']);
  $address = trim($_POST['costumerAddress']);
  $email   = trim($_POST['costumerEmail']);
  $phone   = trim($_POST['costumerPhonenumber']);

  $stmt = $conn->prepare("INSERT INTO costumer (costumerName, costumerAddress, costumerEmail, costumerPhonenumber) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $address, $email, $phone);

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
      <a href="cheakout.php">Check Out</a>
      <a href="view_orders.php">View Orders</a>
      <a href="about.php">About Me</a>
    </div>
  </nav>

  <div class="form-wrapper">
    <h2>Add New Customer</h2>
    <?php echo $feedback; ?>
    <form method="POST" class="form">
      <label for="costumerName">Name:</label>
      <input type="text" name="costumerName" id="costumerName" required>

      <label for="costumerAddress">Address</label>
      <input type="address" name="costumerAddress" id="costumerAddress" required>

      <label for="costumerEmail">Email:</label>
      <input type="email" name="costumerEmail" id="costumerEmail" required>

      <label for="costumerPhonenumber">Phone:</label>
      <input type="text" name="costumerPhonenumber" id="costumerPhonenumber" required>

      <button type="submit" class="btn">Add Customer</button>
    </form>
  </div>
</div>

</body>
</html>
