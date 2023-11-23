<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shopping Cart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../global.css">
</head>
<body>
    <?php
    error_reporting(0);
    require '../Components/navbar.php';

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

    // Check if the user is logged in
    if (isset($_SESSION['current_uuid'])) {
        $userId = $_SESSION['current_uuid'];

        // Query to retrieve cart content for the current user
        $sqlRetrieveCart = "SELECT cart_content FROM carts WHERE user_id = '$userId'";
        $resultRetrieveCart = $conn->query($sqlRetrieveCart);

        if ($resultRetrieveCart->num_rows > 0) {
            $row = $resultRetrieveCart->fetch_assoc();
            $cartContent = json_decode($row['cart_content'], true);

            // Display cart items
            if (!empty($cartContent)) {
                echo '<h2>Your Cart:</h2>';
                $totalPrice = 0;

                // Iterate through each product in the cart
                foreach ($cartContent as $productId) {
                    // Query to retrieve product details, including quantity
                    $sqlRetrieveProduct = "SELECT product_id, product_name, product_price, product_quantity FROM products WHERE product_id = $productId";
                    $resultRetrieveProduct = $conn->query($sqlRetrieveProduct);

                    if ($resultRetrieveProduct->num_rows > 0) {
                        $product = $resultRetrieveProduct->fetch_assoc();

                        // Check if the product is in stock
                        if ($product['product_quantity'] > 0) {
                            echo '<div class="cart_container">';
                            echo '<p>' . $product['product_name'] . ' - ₹' . $product['product_price'] . '</p>';

                            $totalPrice += $product['product_price'];

                            // Update product quantity in the database
                            $newQuantity = $product['product_quantity'] - 1;
                            $sqlUpdateQuantity = "UPDATE products SET product_quantity = $newQuantity WHERE product_id = {$product['product_id']}";
                            $conn->query($sqlUpdateQuantity);

                            // Delete product if quantity reaches zero
                            if ($newQuantity === 0) {
                                $sqlDeleteProduct = "DELETE FROM products WHERE product_id = {$product['product_id']}";
                                $conn->query($sqlDeleteProduct);
                            }

                            // Add the product_id to the orders table as pid
                            $pid = $product['product_id'];
                        } else {
                            echo '<div class="cart_container out_of_stock">';
                            echo '<p>' . $product['product_name'] . ' - Out of Stock</p>';
                        }

                        echo '</div>';
                    }
                }

                // Display total price and Purchase button
                echo '<h3>Total Price: ₹' . $totalPrice . '</h3>';
                echo '<form method="post">';
                echo '<input type="hidden" name="totalPrice" value="' . $totalPrice . '">';
                echo '<input type="hidden" name="pid" value="' . $pid . '">';
                echo '<button class="product_button" type="submit" name="purchase">Purchase</button>';
                echo '</form>';

                // Handle the form submission for purchasing items in the cart
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase'])) {
                    // Insert order details into the orders table with UUID for order_id
                    $sqlInsertOrder = "INSERT INTO orders (order_id, customer_id, pid, order_date, order_price) VALUES (UUID(), '$userId', '$pid', NOW(), '$totalPrice')";
                    $resultInsertOrder = $conn->query($sqlInsertOrder);

                    if ($resultInsertOrder) {
                        // Clear the cart for the user
                        $sqlClearCart = "UPDATE carts SET cart_content = '[]' WHERE user_id = '$userId'";
                        $resultClearCart = $conn->query($sqlClearCart);

                        if ($resultClearCart) {
                            echo '<p>Order placed successfully.</p>';
                            // You may choose to redirect the user or display a confirmation message
                        } else {
                            echo '<p>Error clearing cart: ' . $conn->error . '</p>';
                        }
                    } else {
                        echo '<p>Error placing order: ' . $conn->error . '</p>';
                    }
                }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
        } else {
            echo 'Error retrieving cart.';
        }
    } else {
        echo '<p class="error_warning">';
            echo 'Please login to use the Cart';
        echo '</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
