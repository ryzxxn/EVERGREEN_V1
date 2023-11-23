<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Product Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../global.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<?php
require '../Components/navbar.php';

function addToCart($conn, $userId, $productId) {
    // Retrieve existing cart content
    $sqlRetrieveCart = "SELECT cart_content FROM carts WHERE user_id = '$userId'";
    $resultRetrieveCart = $conn->query($sqlRetrieveCart);

    if ($resultRetrieveCart->num_rows > 0) {
        $row = $resultRetrieveCart->fetch_assoc();
        $cartContent = json_decode($row['cart_content'], true);
    } else {
        // Initialize cart content if not present
        $cartContent = [];
    }

    // Add the new product to the cart
    if (!in_array($productId, $cartContent)) {
        $cartContent[] = $productId;

        // Update cart content in the database
        $cartContentJson = json_encode($cartContent);
        $sqlUpdateCart = "UPDATE carts SET cart_content = '$cartContentJson' WHERE user_id = '$userId'";
        $resultUpdateCart = $conn->query($sqlUpdateCart);

        if ($resultUpdateCart) {
            return "Product added to cart successfully.";
        } else {
            return "Error updating cart: " . $conn->error;
        }
    } else {
        return "Product is already in the cart.";
    }
}

// Check if the form is submitted
// Establish the database connection
$host = 'localhost';
$dbname = 'evergreen';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from the URL
if (isset($_GET['pid'])) {
    $pid = (int)$_GET['pid'];

    // Query to retrieve product details from the products table
    $sqlRetrieveProductDetails = "SELECT products.*, users.firstname AS seller_firstname, users.lastname AS seller_lastname
                                  FROM products
                                  JOIN lists ON products.product_id = lists.pid
                                  JOIN users ON lists.seller_id = users.uid
                                  WHERE products.product_id = $pid";

    $resultProductDetails = $conn->query($sqlRetrieveProductDetails);

    // Check if the product exists
    if ($resultProductDetails->num_rows > 0) {
        $product = $resultProductDetails->fetch_assoc();
        ?>
        <div class="product_details">
            <img class="product_img" src="<?php echo $product['product_url']; ?>" alt="Product Image"
                 style="max-width: 300px; max-height: 300px;">
            <div class="item_inner">
                <h2><?php echo $product['product_name']; ?></h2>
                <p>Price: ₹ <?php echo $product['product_price']; ?></p>
                <p>Seller: <?php echo $product['seller_firstname'] . ' ' . $product['seller_lastname']; ?></p>

                <?php
                // Check if the product is in stock
                if ($product['product_quantity'] > 0) {
                    ?>
                    <form method="post" action="product_details.php?pid=<?php echo $pid; ?>">
                        <button class="product_button" type="submit" name="addToCart">Add to Cart</button>
                    </form>
                    <?php
                } else {
                    echo '<p class="out_of_stock">Out of Stock</p>';
                }
                ?>
            </div>
        </div>
        <?php

        // Handle the form submissions
        if (isset($_POST['purchase'])) {
            // Add logic for purchasing the product (e.g., redirect to the payment page)
            echo 'Product purchased: ' . $product['product_id'];
        } elseif (isset($_POST['addToCart'])) {
            // Check if the user is logged in
            if (isset($_SESSION['current_uuid'])) {
                $userId = $_SESSION['current_uuid'];

                // Call the addToCart function
                $addToCartResult = addToCart($conn, $userId, $pid);

                // Display the result message
                echo $addToCartResult;
            } else {
                echo "User not logged in.";
            }
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not specified in the URL.";
}

// Close the database connection
$conn->close();
?>

</body>
</html>
