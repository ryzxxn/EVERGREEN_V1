<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../global.css">
</head>
<body>
<?php
require '../Components/navbar.php';
?>

<?php
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

// Query to retrieve data from the lists table
$sqlRetrieveListings = "SELECT lists.*, products.product_name, products.product_price, products.product_url, users.firstname AS seller_firstname, users.lastname AS seller_lastname
                            FROM lists
                            JOIN products ON lists.pid = products.product_id
                            JOIN users ON lists.seller_id = users.uid";

$resultListings = $conn->query($sqlRetrieveListings);
?>
<h2>Shop</h2>

<?php
// Check if there are rows in the result
if ($resultListings->num_rows > 0) {
    // Loop through each row in the result
    while ($row = $resultListings->fetch_assoc()) {
        // Output product details with a link and image
        echo '<div class="shop_item">';
        echo '<a class="temp_a" href="product_details.php?pid=' . $row['pid'] . '">';
            echo '<img class="product_img" src="' . $row['product_url'] . '" alt="Product Image" style="max-width: 100px; max-height: 100px;">'; // Adjust image styling as needed
                echo '<div class="item_detail_container">';
                    echo 'Product Name: ' . $row['product_name'];
                    echo "<br>";
                    echo '₹' . $row['product_price'];
                    echo "<br>";
                    echo 'Seller: ' . $row['seller_firstname'] . ' ' . $row['seller_lastname'];
                echo '</div>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No listings found.";
}

// Close the database connection
$conn->close();
?>
</body>
</html>
