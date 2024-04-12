<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all products initially (or filter by specific criteria if needed)
$sql = "SELECT * FROM products";

// Handle search query if submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify the SQL query to filter products based on search criteria
    $sql .= " WHERE name LIKE '%$search%' OR id LIKE '%$search%' ORDER BY id ASC";
    
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h2>View Products</h2>
    <form method="GET">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search">
        <input type="submit" value="Search">
    </form>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr id="product_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="#" class="delete_product" data-id="<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="products.php">Back to Products</a>

    <script>
        $(document).ready(function(){
            $(".delete_product").click(function(e){
                e.preventDefault();
                var productId = $(this).data("id");
                if(confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: 'delete_product.php',
                        type: 'POST',
                        data: {id: productId},
                        success: function(response){
                            $("#product_" + productId).remove();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>