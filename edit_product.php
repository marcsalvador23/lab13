<?php
include 'db_config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <a href="products.php">Back to Products</a>

</head>
<body>
    <h2>Edit Product</h2>
    <form action="edit_product.php?id=<?php echo $id; ?>" method="post">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
        <label>Description:</label><br>
        <textarea name="description"><?php echo $row['description']; ?></textarea><br>
        <label>Price:</label><br>
        <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>