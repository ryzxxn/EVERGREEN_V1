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
        if (!isset($_SESSION['current_uuid'])) {
            // Redirect to a certain PHP page
            header("Location: /index.php");
            exit(); // Ensure that no further code is executed after the redirect
        }
    ?>
    <?php
        require '../Components/quickaccess.php';
    ?>

    <h2>My Blogs</h2>

<?php
$host = 'localhost';
$dbname = 'evergreen';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlBlog = "SELECT * FROM `blogs` WHERE `blogCreator_id`='" . $_SESSION['current_uuid'] . "'";
$result = $conn->query($sqlBlog);
// print_r($result); 

if ($result && $result->num_rows > 0) {
    // Fetch all blog data
    $blogs = $result->fetch_all(MYSQLI_ASSOC);

    // Display the blog list
    foreach ($blogs as $blog) {
        echo '<div class="blog_item">';
        echo '<a href="blog_details.php?blog_id=' . $blog['blog_id'] . '">';
        echo 'Title: ' . $blog['blog_title'];
        echo '<br>';
        echo 'Creator: ' . $blog['blogCreator_name'];
        echo '<br>';
        echo 'Rating: ' . $blog['blog_rating'];
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No blogs found.";
}

// Close the connection
$conn->close();
?>
    </body>
</html>