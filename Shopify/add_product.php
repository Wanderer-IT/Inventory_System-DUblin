<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['productName'];
  $price = $_POST['productPrice'];
  $quantity = $_POST['productQuantity'];
  $categoryID = $_POST['categoryID'];

  $photoPath = '';
  if (!empty($_FILES['productPhoto']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $photoPath = $targetDir . basename($_FILES["productPhoto"]["name"]);
    move_uploaded_file($_FILES["productPhoto"]["tmp_name"], $photoPath);
  }

  $stmt = $conn->prepare("INSERT INTO product (productName, productPrice, productQuantity, productPhoto, categoryID) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sdisi", $name, $price, $quantity, $photoPath, $categoryID);

  if ($stmt->execute()) {
    header("Location: product.php");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
