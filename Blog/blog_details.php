<?php
// blog_details.php

$blog_id = isset($_GET['blog_id']) ? $_GET['blog_id'] : '';

// Validate $blog_id if needed

// Database connection parameters
$host = 'localhost';
$dbname = 'evergreen';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize $blog_id if needed
$blog_id = $conn->real_escape_string($blog_id);

// Fetch blog details from the database using $blog_id
$sqlBlogDetails = "SELECT * FROM blogs WHERE blog_id = '$blog_id'";
$result = $conn->query($sqlBlogDetails);

if ($result && $result->num_rows > 0) {
    $blog = $result->fetch_assoc(); // Fetch blog details
} else {
    // Handle the case where the blog with the given ID is not found
    die("Blog not found");
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../global.css">
</head>
<body>
    <?php require '../Components/navbar.php'; ?>

    <div class='id_container'>
        <div class='content'>
            <h1><?php echo $blog['blog_title']; ?></h1>
            <h3><?php echo $blog['blogCreator_name']; ?>.</h3>
            <p><?php echo $blog['blog_content']; ?>.</p>
        </div>
    </div>
</body>
</html>
