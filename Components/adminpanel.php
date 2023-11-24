<?php
// Include your database connection details
$host = 'localhost';
$dbname = 'evergreen';
$user = 'root';
$pass = '';

// Create a new database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total admins and total users
$sqlAdminCount = "SELECT COUNT(*) as adminCount FROM users WHERE role = 'Admin'";
$sqlUserCount = "SELECT COUNT(*) as userCount FROM users";

$resultAdminCount = $conn->query($sqlAdminCount);
$resultUserCount = $conn->query($sqlUserCount);

// Fetch all users from the 'users' table
$sqlGetUsers = "SELECT * FROM users";
$resultUsers = $conn->query($sqlGetUsers);

// Fetch total products
$sqlProductCount = "SELECT COUNT(*) as productCount FROM products";
$resultProductCount = $conn->query($sqlProductCount);

// Fetch all products from the 'products' table
$sqlGetProducts = "SELECT * FROM products";
$resultProducts = $conn->query($sqlGetProducts);

// Fetch total orders
$sqlOrderCount = "SELECT COUNT(*) as orderCount FROM orders";
$resultOrderCount = $conn->query($sqlOrderCount);

// Fetch all orders from the 'orders' table
$sqlGetOrders = "SELECT * FROM orders";
$resultOrders = $conn->query($sqlGetOrders);

// Fetch the most purchased product
$sqlMostPurchasedProductWithInfo = "
    SELECT d.pid, COUNT(d.pid) as purchaseCount, p.product_name, p.product_price
    FROM data d
    JOIN products p ON d.pid = p.product_id
    GROUP BY d.pid
    ORDER BY purchaseCount DESC
    LIMIT 1";
$resultMostPurchasedProductWithInfo = $conn->query($sqlMostPurchasedProductWithInfo);

// Fetch the most purchased seller
$sqlMostPurchasedSellerWithUser = "
    SELECT d.seller_id, COUNT(d.seller_id) as purchaseCount, u.firstname, u.lastname
    FROM data d
    JOIN users u ON d.seller_id = u.uid
    GROUP BY d.seller_id
    ORDER BY purchaseCount DESC
    LIMIT 1";
$resultMostPurchasedSellerWithUser = $conn->query($sqlMostPurchasedSellerWithUser);

// Fetch other valuable information
$sqlUniqueCustomersPerSeller = "
    SELECT seller_id, COUNT(DISTINCT customer_id) as uniqueCustomers
    FROM data
    GROUP BY seller_id";
$resultUniqueCustomersPerSeller = $conn->query($sqlUniqueCustomersPerSeller);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        .user-container, .product-container, .order-container {
            height: 70vh;
            overflow: scroll;
            margin: 0rem 3rem;
            border: 1px solid #ccc;
            padding: .5rem 2rem;
            margin-bottom: 2rem;
        }

        .user_cont, .product_cont, .order_cont {
            display: flex;
            border: 1px solid #ccc;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<?php
require '../Components/quickaccess.php';
?>

<h2>Admin Panel</h2>

<!-- Display Users -->
<div class='user-container'>
    <h3>User Data</h3>
    <?php
    // Check if there are users
    if ($resultUsers->num_rows > 0) {
        // Output each user's data with a delete button
        while ($row = $resultUsers->fetch_assoc()) {
            echo "<div id='{$row['uid']}' class='info_user'>";
            echo "<div class='user_cont'>";
            echo "<div>";
            echo "<p>User ID: {$row['uid']}</p>";
            echo "<p>Email: {$row['email']}</p>";
            echo "<p>First Name: {$row['firstname']}</p>";
            echo "<p>Last Name: {$row['lastname']}</p>";
            echo "<p>Address: {$row['address']}</p>";
            echo "</div>";
            // echo "<button onclick='deleteUser(\"{$row['uid']}\")'>Delete User</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "No users found.";
    }

    // Display total admins and total users
    if ($resultAdminCount && $resultUserCount) {
        $adminCount = $resultAdminCount->fetch_assoc()['adminCount'];
        $userCount = $resultUserCount->fetch_assoc()['userCount'];
        echo "<p>Total Admins: $adminCount</p>";
        echo "<p>Total Users: $userCount</p>";
    } else {
        echo "Error fetching user counts.";
    }
    ?>
</div>

<!-- Display Products -->
<div class='product-container'>
    <h3>Product Data</h3>
    <?php
    // Check if there are products
    if ($resultProducts->num_rows > 0) {
        // Output each product's data
        while ($row = $resultProducts->fetch_assoc()) {
            echo "<div id='{$row['product_id']}' class='product_cont'>";
            echo "<div>";
            echo "<p>Product ID: {$row['product_id']}</p>";
            echo "<p>Product Name: {$row['product_name']}</p>";
            echo "<p>Price: {$row['product_price']}</p>";
            echo "<p>Description: {$row['product_description']}</p>";
            echo "<p>Quantity: {$row['product_quantity']}</p>";
            // Add other product fields as needed
            echo "</div>";
            // echo "<button onclick='deleteProduct(\"{$row['product_id']}\")'>Delete Product</button>";
            echo "</div>";
        }
    } else {
        echo "No products found.";
    }

    // Display total products
    if ($resultProductCount) {
        $productCount = $resultProductCount->fetch_assoc()['productCount'];
        echo "<p>Total Products: $productCount</p>";
    } else {
        echo "Error fetching product count.";
    }
    ?>
</div>

<!-- Display Orders -->
<div class='order-container'>
    <h3>Order Data</h3>
    <?php
    // Check if there are orders
    if ($resultOrders->num_rows > 0) {
        // Output each order's data
        while ($row = $resultOrders->fetch_assoc()) {
            echo "<div id='{$row['order_id']}' class='order_cont'>";
            echo "<div>";
            echo "<p>Order ID: {$row['order_id']}</p>";
            echo "<p>Customer ID: {$row['customer_id']}</p>";
            echo "<p>Product ID: {$row['pid']}</p>";
            echo "<p>Order Date: {$row['order_date']}</p>";

            echo "<p>Total: {$row['order_price']}</p>";
            // Add other order fields as needed
            echo "</div>";
            // echo "<button onclick='deleteOrder(\"{$row['order_id']}\")'>Delete Order</button>";
            echo "</div>";
        }
    } else {
        echo "No orders found.";
    }

    // Display total orders
    if ($resultOrderCount) {
        $orderCount = $resultOrderCount->fetch_assoc()['orderCount'];
        echo "<p>Total Orders: $orderCount</p>";
    } else {
        echo "Error fetching order count.";
    }
    ?>
</div>

<!-- Display additional information -->
<div>
    <h3>Additional Information</h3>

    <!-- Display most purchased product -->
    <?php
if ($resultMostPurchasedProductWithInfo) {
    $mostPurchasedProductWithInfo = $resultMostPurchasedProductWithInfo->fetch_assoc();
    echo "<p>Most Purchased Product:</p>";
    echo "<p>Product ID: {$mostPurchasedProductWithInfo['pid']}</p>";
    echo "<p>Product Name: {$mostPurchasedProductWithInfo['product_name']}</p>";
    echo "<p>Product Price: {$mostPurchasedProductWithInfo['product_price']}</p>";
    echo "<p>Purchase Count: {$mostPurchasedProductWithInfo['purchaseCount']}</p>";
} else {
    echo "Error fetching most purchased product with product information.";
}

// Display information about unique customers per seller
if ($resultUniqueCustomersPerSeller) {
    echo "<p>Unique Customers per Seller:</p>";
    while ($row = $resultUniqueCustomersPerSeller->fetch_assoc()) {
        echo "<p>Seller ID: {$row['seller_id']}, Unique Customers: {$row['uniqueCustomers']}</p>";
    }
} else {
    echo "Error fetching information about unique customers per seller.";
}
?>

    <!-- Display most purchased seller -->
    <?php
        if ($resultMostPurchasedSellerWithUser) {
            $mostPurchasedSellerWithUser = $resultMostPurchasedSellerWithUser->fetch_assoc();
            echo "<p>Most Purchased Seller:</p>";
            echo "<p>Seller ID: {$mostPurchasedSellerWithUser['seller_id']}</p>";
            echo "<p>Seller Name: {$mostPurchasedSellerWithUser['firstname']} {$mostPurchasedSellerWithUser['lastname']}</p>";
            echo "<p>Purchase Count: {$mostPurchasedSellerWithUser['purchaseCount']}</p>";
        } else {
            echo "Error fetching most purchased seller with user information.";
        }
        $conn->close();
?>
</div>

<!-- JavaScript functions for user, product, and order deletion -->
<script>
    // JavaScript function to handle user deletion
    function deleteUser(userId) {
        // You may want to add a confirmation prompt before deleting the user

        // Make an AJAX request to delete the user
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_user.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Remove the user's HTML element without reloading the page
                var userElement = document.getElementById(userId);
                if (userElement) {
                    userElement.remove();
                }
            }
        };
        xhr.send("userId=" + userId);
    }

    // JavaScript function to handle product deletion
    function deleteProduct(productId) {
        // You may want to add a confirmation prompt before deleting the product

        // Make an AJAX request to delete the product
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_product.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Remove the product's HTML element without reloading the page
                var productElement = document.getElementById(productId);
                if (productElement) {
                    productElement.remove();
                }
            }
        };
        xhr.send("productId=" + productId);
    }

    // JavaScript function to handle order deletion
    function deleteOrder(orderId) {
        // You may want to add a confirmation prompt before deleting the order

        // Make an AJAX request to delete the order
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_order.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Remove the order's HTML element without reloading the page
                var orderElement = document.getElementById(orderId);
                if (orderElement) {
                    orderElement.remove();
                }
            }
        };
        xhr.send("orderId=" + orderId);
    }
</script>

</body>
</html>
