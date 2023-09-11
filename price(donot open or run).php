<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plant_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$n = 0; // Number of entries to create
$minPrice = 599; // Minimum price value
$maxPrice = 3999; // Maximum price value

for ($i = 0; $i < $n; $i++) {
    $name = "Plant " . ($i + 1);
    $price = rand($minPrice, $maxPrice);

    $sql = "INSERT INTO price (price) VALUES ($price)";

    if ($conn->query($sql) === TRUE) {
        echo "Entry $i: New record created successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>