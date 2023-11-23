<?php
// Include your authentication and database connection logic here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID to be deleted
    $userId = $_POST['userId'];

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

    // Prepare and execute the SQL statement to delete the user
    $sqlDeleteUser = "DELETE FROM users WHERE uid = '$userId'";
    if ($conn->query($sqlDeleteUser) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
