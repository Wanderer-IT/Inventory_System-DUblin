<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/Index.css">
    <link rel="stylesheet" type="text/js" href="assets/Funcs.js">
    
</head>

<body>

<h2>Inventory List</h2>

<div class="btn-container">
    <a href="add.php" class="btn">Add Product</a>
</div>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM products");

    while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$row['id']."</td>
            <td>".$row['product_name']."</td>
            <td>".$row['quantity']."</td>
            <td>".$row['price']."</td>

            <td>
                <a href='edit.php?id=".$row['id']."' class='action-btn edit-btn'>Edit</a>
                <a href='delete.php?id=".$row['id']."' class='action-btn delete-btn'>Delete</a>
            </td>
          </tr>";
    }
    ?>

</table>

</body>
</html>
