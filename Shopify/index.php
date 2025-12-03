<?php
include 'database.php';

$sql = "SELECT p.productID, p.productName, p.productPrice, p.productQuantity, p.productPhoto, 
               c.categoryType 
        FROM product p
        INNER JOIN category c ON p.categoryID = c.categoryID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Shop</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <nav class="nav">
      <div class="nav-logo">
        <h1>My Shop</h1>
      </div>
      <div class="nav-links">
        <a href="product.php">Shop</a>
        <a href="checkout.php">Check Out</a>
      </div>
    </nav>

    <section class="hero">
      <div class="hero-intro">
        <h1>Products for my Sari-Sari Store for Sale!</h1>
        <a href="add_customer.php" class="btn">Shop Now!</a>
      </div>
      <div class="hero-image">
        <img src="Store.jpg" alt="Store Image">
      </div>
    </section>

    <section class="products">
      <div class="product-list">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>
                    <div class='product-image'>";
                      if (!empty($row['productPhoto'])) {
                        echo "<img src='{$row['productPhoto']}' alt='{$row['productName']}'>";
                      } else {
                        echo "<img src='placeholder.png' alt='No Image'>";
                      }
            echo    "</div>
                    <div class='product-info'>
                      <h3>{$row['productName']}</h3>
                      <p>Category: {$row['categoryType']}</p>
                      <p>Price: ₱{$row['productPrice']}</p>
                      <p>Stock: {$row['productQuantity']}</p>
                    </div>
                  </div>";
          }
        } else {
          echo "<p></p>";
        }
        ?>
      </div>
    </section>
  </div>

</body>
</html>
