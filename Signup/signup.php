<?php
require '../Components/navbar.php';

error_reporting(0);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Check if the email ends with "@gmail.com"
    if (endsWith($email, '@gmail.com')) {
        // Database connection parameters
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

        // Prepare and execute the SQL statement
        $sqlCreateUser = "INSERT INTO users (uid, email, password, firstname, lastname, role, phone, verified, account_created, address)
        VALUES (UUID(), '$email', '$password', '$firstname', '$lastname', 'User', '$phone', 0, NOW(), '$address')";

        if ($conn->query($sqlCreateUser) === TRUE) {
            echo "User created successfully";
            header('Location: ../Login/login.php');
            exit();
        } else {
            echo "Error creating user: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        echo "Invalid email address. Please use a Gmail account.";
    }
}

// Function to check if a string ends with a specific substring
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}
?>

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
    <form action="signup.php" method="post">
        <div class="form_container">
            <h2>Signup</h2>
            <label>Email</label>
            <input name="email" class='signup_input' type="text" required>
            
            <label>Password</label>
            <input name="password" class='signup_input' type="password" required>
            
            <label>First Name</label>
            <input name="firstname" class='signup_input' type="text" required>
            
            <label>Last Name</label>
            <input name="lastname" class='signup_input' type="text" required>
            
            <label>Address</label>
            <input name="address" class='signup_input' type="text" required>
            
            <label>Phone no.</label>
            <input name="phone" class='signup_input' type="number" required>
            
            <div class="submit_container">
                <input type="submit" value="Submit">
            </div>
            
            <label>Already have an account?</label>
            <div class="submit_container">
                <a href='../Login/login.php' class='signup_submit'>Login</a>
            </div>
        </div>
    </form>
</body>
</html>
