<?php
include 'db_config.php';

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "Product deleted successfully";
} else {
    echo "Error deleting product: " . mysqli_error($conn);
}
?>