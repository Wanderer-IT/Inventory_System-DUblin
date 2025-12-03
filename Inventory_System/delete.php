<?php
include 'db.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM products WHERE id=$id");

echo "<script>alert('Product Deleted'); window.location='index.php';</script>";
?>
