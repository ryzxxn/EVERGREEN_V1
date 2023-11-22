<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta class="description" content="">
        <meta class="viewport" content="width=device-width, initial-scale=1">
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

<?php
// error_reporting(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    $blog_content = $_POST['blog_content'];
    $blog_title = $_POST['blog_title'];

    // Validate and sanitize user input
    // ...

    $host = 'localhost';
    $dbname = 'evergreen';
    $user = 'root';
    $password = '';

    $conn = new mysqli($host, $user, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sqlsaveBlog = $conn->prepare("INSERT INTO blogs (blog_id, blogCreator_id, blogCreator_name, blog_title, blog_content, blog_rating)
                                   VALUES (UUID(), ?, ?, ?, ?, 0)");

    $sqlsaveBlog->bind_param("ssss", $_SESSION["current_uuid"], $_SESSION["current_firstname"], $blog_title, $blog_content);

    if ($sqlsaveBlog->execute()) {
        echo "Blog posted successfully!";
    } else {
        echo "Error posting blog: " . $sqlsaveBlog->error;
    }

    $sqlsaveBlog->close();
    $conn->close();
}
?>


<form action="postblog.php" method="post">
        <div class="form_container">
            <h2>Post your Blog</h2>
            <div class="input_container">
              <label>Blog Title</label>
              <input
              name='blog_title'
                class='signup_input' type="text" />
            </div>
    
            <div class="input_container">
              <label>Blog Content</label>
              <input
              name='blog_content'
                class='signup_input' type="text" />
            </div>
    
            <div class="submit_container">
                <input type="submit" class='signup_submit'>
            </div>
          </div>
</form>
    </body>
</html>