<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Orders</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../global.css">
    <style>
        .order-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .order-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<?php
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

    // Query to retrieve order details for the current user, ordered by price
    $sqlRetrieveOrders = "SELECT * FROM orders WHERE customer_id = '$userId' ORDER BY order_price";
    $resultRetrieveOrders = $conn->query($sqlRetrieveOrders);
?>
<div class="order_container">
<?php
    if ($resultRetrieveOrders->num_rows > 0) {
        while ($row = $resultRetrieveOrders->fetch_assoc()) {
            ?>
            <div class="order-container">
                <div class="order-header">Order ID: <?php echo $row['order_id']; ?></div>
                <div class="order-details">
                    <div>Product IDs: <?php echo implode(', ', json_decode($row['pid'])); ?></div>
                    <div>Order Date: <?php echo $row['order_date']; ?></div>
                    <div>Total Price: ₹<?php echo $row['order_price']; ?></div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No orders found.</p>';
    }
} else {
    echo 'User not logged in.';
}
?>
</div>
<?php

// Close the database connection
$conn->close();
?>

</body>
</html>
