<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h2>Product List</h2>
    <?php
    if ($_SESSION['user_role'] === 'Admin') {
        echo '<a href="add_product.php"><button>Add Product</button></a>';
        echo '<a href="view_products.php"><button>View All Products</button></a>';
    } elseif ($_SESSION['user_role'] === 'Customer') {
        echo '<a href="order_product.php"><button>Order</button></a>';
    }
    ?>

    <form action="products.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>
</html>
