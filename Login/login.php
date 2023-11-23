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

// Error reporting and user input retrieval
error_reporting(0);
$login_email = isset($_POST['email']) ? $_POST['email'] : '';
$login_password = isset($_POST['password']) ? $_POST['password'] : '';

// echo "current user is " . $_SESSION["current_uuid"] . ".<br>";
// echo $login_email;
// echo "<br>";
// echo $login_password;

// Call the auth function
auth($login_email, $login_password);

function auth($e, $p)
{
    $host = 'localhost';
    $dbname = 'evergreen';
    $user = 'root';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user inputs
    $email = $conn->real_escape_string($e);
    $password = $conn->real_escape_string($p);

    $sqlAuth = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sqlAuth);

    if ($result && $result->num_rows > 0) {
        // User authenticated successfully
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION["current_uuid"] = $row['uid'];
        $_SESSION["current_email"] = $row['email'];
        $_SESSION["current_firstname"] = $row['firstname'];
        $_SESSION["current_lastname"] = $row['lastname'];
        $_SESSION["current_address"] = $row['address'];
        $_SESSION["current_role"] = $row['role'];
        $_SESSION["current_phone"] = $row['phone'];
        $_SESSION["current_verified"] = $row['verified'];

        // Check if a cart record already exists for the user
        $userId = $_SESSION["current_uuid"];
        $sqlCheckCart = "SELECT * FROM carts WHERE user_id = '$userId'";
        $resultCheckCart = $conn->query($sqlCheckCart);

        if ($resultCheckCart->num_rows === 0) {
            // Cart record doesn't exist, create one
            $cartId = uniqid(); // or UUID() based on your database
            $cartContent = json_encode([]); // Initialize with an empty array

            $sqlInitializeCart = "INSERT INTO carts (cart_id, user_id, cart_content) VALUES ('$cartId', '$userId', '$cartContent')";
            $resultInitializeCart = $conn->query($sqlInitializeCart);

            if ($resultInitializeCart) {
                echo "Cart initialized successfully.";
            } else {
                echo "Error initializing cart: " . $conn->error;
            }
        }

        // Redirect to the homepage or perform further actions
        header("Location: /index.php");
        exit();
    } else {
        // Authentication failed
        echo "Invalid email or password";
    }

    // Close the connection
    $conn->close();
}
?>

<form action="login.php" method="post">
    <div class="form_container">
        <h2>Login</h2>
        <div class="input_container">
            <label>Email</label>
            <input name="email" class='signup_input' type="text">
        </div>

        <div class="input_container">
            <label>Password</label>
            <input name="password" class='signup_input' type="password">
        </div>

        <div class="submit_container">
            <input type="submit">
        </div>
    </div>
</form>
    </body>
</html>
