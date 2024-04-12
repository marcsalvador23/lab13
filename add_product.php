<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $description = $price = "";
$name_err = $description_err = $price_err = ""; // Initialize $price_err here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name for the product.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description for the product.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate price
    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter a price for the product.";
    } else {
        $price = trim($_POST["price"]);
        // Additional validation can be added here if necessary
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($description_err) && empty($price_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_description, $param_price);

            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_price = $price;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Product added successfully, redirect to index.php
                header("Location: products.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err; ?></span>
        </div>
        <div>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"><?php echo $description; ?></textarea>
            <span><?php echo $description_err; ?></span>
        </div>
        <div>
    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?php echo $price; ?>">
    <span><?php echo $price_err; ?></span>
</div>

        <div>
            <input type="submit" value="Add">
        </div>
    </form>
</body>
</html>