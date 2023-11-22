<?php

function connectToDatabase() {
    $host = 'localhost';
    $dbname = 'evergreen';
    $user = 'root';
    $password = '';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function insertProduct($conn, $product_name, $product_description, $product_quantity, $product_price, $imageUrl) {
    $sqlInsertProduct = "INSERT INTO products (product_name, product_description, product_quantity, product_price, product_url)
                         VALUES ('$product_name', '$product_description', $product_quantity, $product_price, '$imageUrl')";

    $result = $conn->query($sqlInsertProduct);
    return $result;
}

function createListing($conn, $seller_uuid, $lastProductId, $list_date) {
    $sqlCreateListing = "INSERT INTO lists (list_id, seller_id, pid, list_date)
                         VALUES (UUID(), '$seller_uuid', '$lastProductId', '$list_date')";

    $result = $conn->query($sqlCreateListing);
    return $result;
}

function uploadImageToDiscord($imageContent) {
    $discordWebhookURL = 'https://discord.com/api/webhooks/1170259862958125066/94u4Ziza65RI0eK_6p2-ypzR-ZMXhU0DpUVUHVrUIWeN6JI3TXf2TomKl95tc20bfnw8';

    $data = [
        'content' => 'Image upload',
    ];

    $files = [
        'file' => $imageContent,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $discordWebhookURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $files);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return [
        'httpCode' => $httpCode,
        'response' => $response,
    ];
}

function getImageUrlFromResponse($discordResponse) {
    // Assuming Discord returns the image URL in the response (adjust accordingly)
    $jsonResponse = json_decode($discordResponse, true);
    return $jsonResponse['attachments'][0]['url'] ?? null;
}

// Main code
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectToDatabase();

    // Process product details
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_quantity = (int)$_POST['product_quantity'];
    $product_price = (int)$_POST['product_price'];
    $seller_uuid = mysqli_real_escape_string($conn, $_SESSION['current_uuid']);
    $list_date = date("Y-m-d");

    // Insert data into the products table
    $result = insertProduct($conn, $product_name, $product_description, $product_quantity, $product_price, '');

    if ($result) {
        // Retrieve the auto-incremented product_id
        $lastProductId = $conn->insert_id;

        // Create a listing in the lists table
        $result1 = createListing($conn, $seller_uuid, $lastProductId, $list_date);

        // Process image upload to Discord
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageContent = curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
            $uploadResult = uploadImageToDiscord($imageContent);
        
            if ($uploadResult['httpCode'] == 200) {
                // Retrieve the image URL from the Discord response
                $imageUrl = getImageUrlFromResponse($uploadResult['response']);
        
                if ($imageUrl) {
                    // Update the product entry with the image URL
                    $updateProductUrl = "UPDATE products SET product_url = '$imageUrl' WHERE product_id = '$lastProductId'";
                    $conn->query($updateProductUrl);
        
                    echo "Product and image uploaded successfully!";
                } else {
                    echo "Error retrieving image URL from Discord response.";
                }
            } else {
                echo "Error uploading image to Discord. Please try again.";
            }
        } else {
            echo "Error uploading image. Please try again.";
        }

    // Close the database connection
    $conn->close();
}
}
?>

<form action="../Postlisting/postlisting.php" method="post" enctype="multipart/form-data">
    <div class="form_container">
        <h2>Create Listing</h2>
        <label>Name</label>
        <input name="product_name" class='signup_input' type="text" required>

        <label>Description</label>
        <input name="product_description" class='signup_input' type="text" required>

        <label>Quantity</label>
        <input name="product_quantity" class='signup_input' type="number" required>

        <label>Price</label>
        <input name="product_price" class='signup_input' type="number" required>

        <label for="image">Select Image (JPG or PNG):</label>
        <input type="file" name="image" id="image" accept="image/jpeg, image/png" required>

        <div class="submit_container">
            <input type="submit" value="Submit">
        </div>
    </div>
</form>
