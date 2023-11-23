<?php
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

// SQL statement to create a users table
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    uid CHAR(36) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    address VARCHAR(255),
    role VARCHAR(255),
    phone INT,
    verified BOOLEAN,
    account_created DATE NOT NULL,
    PRIMARY KEY (uid),
    UNIQUE (email)
)";

$sqlData = "CREATE TABLE IF NOT EXISTS data (
    order_id VARCHAR(36),
    customer_id VARCHAR(36),
    seller_id INT,
    product_id INT,
    PRIMARY KEY (order_id)
)
";

// SQL statement to create a blogs table with a foreign key constraint
$sqlBlogs = "CREATE TABLE IF NOT EXISTS blogs (
    blog_id CHAR(36) NOT NULL,
    blogCreator_id CHAR(36) NOT NULL,
    blogCreator_name VARCHAR(255) NOT NULL,
    blog_title VARCHAR(255),
    blog_content TEXT,
    blog_rating INT,
    PRIMARY KEY (blog_id),
    FOREIGN KEY (blogCreator_id) REFERENCES users(uid)
)";

$sqlList = "CREATE TABLE IF NOT EXISTS lists (
    list_id CHAR(36) NOT NULL,
    seller_id CHAR(36) NOT NULL,
    pid INT NOT NULL,
    list_date DATE NOT NULL,
    PRIMARY KEY (list_id),
    FOREIGN KEY (seller_id) REFERENCES users(uid),
    FOREIGN KEY (pid) REFERENCES products(product_id)
)";


$sqlProduct = "CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT,
    product_name VARCHAR(255),
    product_description VARCHAR(255),
    product_quantity INT,
    product_price INT,
    product_url VARCHAR(255),
    PRIMARY KEY (product_id)
)";

$sqlOrder = "CREATE TABLE IF NOT EXISTS orders (
    order_id CHAR(36) NOT NULL,
    customer_id CHAR(36) NOT NULL,
    pid INT,
    order_date DATE NOT NULL,
    order_price VARCHAR(255),
    PRIMARY KEY (order_id),
    FOREIGN KEY (customer_id) REFERENCES users(uid)
)";

$sqlCart = "CREATE TABLE IF NOT EXISTS carts (
    cart_id CHAR(36) NOT NULL,
    user_id CHAR(36) UNIQUE NOT NULL,
    cart_content JSON,
    PRIMARY KEY (cart_id),
    FOREIGN KEY (user_id) REFERENCES users(uid)
)";

// Execute the SQL statements
if ($conn->query($sqlData) === TRUE && $conn->query($sqlUsers) === TRUE && $conn->query($sqlProduct) === TRUE && $conn->query($sqlOrder) === TRUE && $conn->query($sqlList) === TRUE && $conn->query($sqlBlogs) === TRUE && $conn->query($sqlCart) === TRUE){
    echo "successfull";
} else {
    echo "Error creating tables: " . $conn->error;
}

// Close the connection
$conn->close();
?>