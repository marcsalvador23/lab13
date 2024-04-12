<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the most recent order for the current user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);

// Check if an order exists
if (!$order) {
    header("Location: products.php");
    exit();
}

// Get product details for the ordered product
$product_id = $order['product_id'];
$sql_product = "SELECT * FROM products WHERE id = $product_id";
$result_product = mysqli_query($conn, $sql_product);
$product = mysqli_fetch_assoc($result_product);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Order Confirmation</h2>
    <p>Your order has been successfully placed!</p>
    
    <h3>Order Details:</h3>
    <p><strong>Product:</strong> <?php echo $product['name']; ?></p>
    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
    <!-- You can display additional order details here -->

    <a href="products.php">Back to Products</a>
</body>
</html>