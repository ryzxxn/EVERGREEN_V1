<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
</head>

<body>

  <div class="page_container">
    <div class="navbar">
      <div class="link_collection">
        <a href="../Home_page/index.php" class="link_home">EVERGREEN</a>
        <a href="" class="link">Plant</a>
        <a href="../Sale_page/sale.php" class="link">Sale</a>
        <a href="" class="link">Blog</a>
        <a href="" class="link">About</a>
      </div>
      <div class="right_signup">

        <?php
        error_reporting(0);
        session_start();
        if ($_SESSION['loggedIn'] == false || $_SESSION == NULL) {
            echo '<button class="cart_button" id="open-cart">'."Open Cart".'</button>';
                        error_reporting(0);
                        //db_connection
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "plant_store";

                        //print_r($_SESSION);

                        //$sql_home = "SELECT user_id FROM customer WHERE email = $email";
                        //$result_home = $conn->query($sql);

                        //print_r($result_home);

                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $_SESSION['loggedIn'] = false;
                        // Check if the user is logged in
                        if (isset($_SESSION['username'])) {
                            //echo 'Hello, ' . $_SESSION['username'] . '!';
                            
                            // echo '<a href="../Sign_up/sign.php" class="dropbtn">';
                            //echo $_SESSION['username'];
                            echo '</a>';
                            echo '<div class="dropdown">
                              <button class="dropbtn">'.$_SESSION['username'].'</button>
                                <div class="dropdown-content">
                                    <a href="#">Profile</a>
                                    <a href="../Home_page/logout2.php">Logout</a>
                                </div>
                            </div>';
                        }
                        else{
                            echo '<a href="../Sign_up/sign.php" class="dropbtn">';
                            echo "Signup";
                            echo '</a>';
                        }
                    }
                    ?>
      </div>
    </div>
    <div class="main">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "plant_store";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "SELECT * FROM plant";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Initialize a counter for tracking the number of entries in the current row
        $entryCounter = 0;

        // Output data using a while loop
        while ($row = $result->fetch_assoc()) {
          // Start a new row container for the first entry in each row
          if ($entryCounter == 0) {
            echo '<div class="row">';
          }

          echo '<div class="element">';
          echo '<div class="img_sect">';
          echo '<img class="plnt_img" src="' . $row["url"] . '" alt="">';
          echo '</div>';
          echo '<div class="plant_info">';
          echo $row["common_name"];
          $id = $row["plant_id"];

          $sql1 = "SELECT `price` FROM `price` WHERE `plant_id` = $id";
          $result1 = $conn->query($sql1);

          for ($i = 0; $i < $result1->num_rows; $i++) {
            $row1 = $result1->fetch_assoc();
            echo "<br>";
            echo "₹ " . $row1["price"];
            echo "<br>";
          }


          echo '</div>';
          echo '<button class="addtocart" data-product="'.$row["common_name"].'" data-price="'.$row1["price"].'">';
          echo "Add to cart";
          echo '</button>';
          echo '</div>';

          $entryCounter++;

          // Close the row container after the 4th entry in the row
          if ($entryCounter % 5 == 0 || $entryCounter === $result->num_rows - 1) {
            echo '</div>';
            $entryCounter = 0;
          }

          // Increment the entry counter
        }
      }

      $conn->close();
      ?>
    </div>
    <div id="slide-cart">
      <div class="cart_style" id="cart-content">
        <h1>Cart</h1>
        <ul id="cart-items"></ul>
        <p>Total: <span id="cart-total">₹0</span></p>
        <button class="cart_button" id="clear-cart">Clear Cart</button>
        <button class="cart_button" id="close-cart">Close Cart</button>
      </div>
      <button onclick="location.href='../Sale_page/payment.php'" class="purchase_cart">Purchse</button>
    </div>
    <div class="footer_details">

    </div>
  </div>
  <script>
    const addToCartButtons = document.querySelectorAll('.addtocart');
    const openCartButton = document.getElementById('open-cart');
    const closeCartButton = document.getElementById('close-cart');
    const clearCartButton = document.getElementById('clear-cart');
    const slideCart = document.getElementById('slide-cart');
    const cartItemsElement = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    let cartItems = [];
    let cartTotal = 0;

    addToCartButtons.forEach(button => {
      button.addEventListener('click', () => {
        console.log("Clicked");
        const product = button.getAttribute('data-product');
        const price = parseFloat(button.getAttribute('data-price'));

        const existingCartItem = cartItems.find(item => item.product === product);
        if (existingCartItem) {
          existingCartItem.quantity++;
        } else {
          cartItems.push({
            product,
            price,
            quantity: 1
          });
        }
        cartTotal += price;

        updateCart();
      });
    });

    openCartButton.addEventListener('click', () => {
      slideCart.style.right = '0';
    });

    closeCartButton.addEventListener('click', () => {
      slideCart.style.right = '-600px';
    });

    clearCartButton.addEventListener('click', () => {
      cartItems = [];
      cartTotal = 0;
      updateCart();
    });

    function updateCart() {
      cartItemsElement.innerHTML = '';
      cartTotalElement.textContent = '₹.' + cartTotal.toFixed(2);

      cartItems.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.product} - ₹.${item.price.toFixed(2)} x ${item.quantity}`;

        const addButton = document.createElement('button');
        addButton.textContent = '+';
        addButton.addEventListener('click', () => {
          item.quantity++;
          cartTotal += item.price;
          updateCart();
        });

        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.addEventListener('click', () => {
          if (item.quantity > 1) {
            item.quantity--;
            cartTotal -= item.price;
          } else {
            cartItems = cartItems.filter(cartItem => cartItem !== item);
            cartTotal -= item.price;
          }
          updateCart();
        });
        
        listItem.appendChild(removeButton);
        listItem.appendChild(addButton);
        cartItemsElement.appendChild(listItem);

      });
    }
  </script>
</body>

</html>