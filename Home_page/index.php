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
                    <a href="index.php" class="link_home">EVERGREEN</a>
                    <a href="" class="link">Plant</a>
                    <a href="../Sale_page/sale.php" class="link">Sale</a>
                    <a href="" class="link">Blog</a>
                    <a href="" class="link">About</a>
                </div>
                <div class="right_signup">
                    <?php
                        error_reporting(0);
                        session_start();
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
                                    <a href="../Home_page/logout.php">Logout</a>
                                </div>
                            </div>';
                        }
                        else{
                            echo '<a href="../Sign_up/sign.php" class="dropbtn">';
                            echo "signup";
                            echo '</a>';
                        }
                    ?>
                </div>
            </div>
            <div class="background">
                EVERGREEN
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 230"><path fill="#1d3e2d" fill-opacity="1" d="M0,160L144,192L288,128L432,64L576,192L720,96L864,96L1008,224L1152,64L1296,32L1440,128L1440,0L1296,0L1152,0L1008,0L864,0L720,0L576,0L432,0L288,0L144,0L0,0Z"></path></svg>
            <div class="information">
                <h1 class="info_main">Welcome to our plant paradise!</h1>
                <h3 class="info_text">Our plant selling website is your one-stop destination for all things green and beautiful. Explore a diverse collection of plants that cater to every gardener, whether you're a seasoned pro or just starting your green journey.</h3>
                <br>
                <h3 class="info_text">Whether you're transforming your living space, creating an outdoor oasis, or looking for the ideal gift, our plant selection offers endless possibilities. Join our growing community of plant enthusiasts who believe in the power of nature to inspire, uplift, and connect.
                Experience the joy of bringing the outdoors in with our exceptional plants. Start your plant shopping journey today and let the magic of nature unfold in your world.</h3>
            </div>
            <br>
            <br>
            <br>
            <div class="information" id="left">
                <h1 class="info_main">Gardening Basics</h1>
                <h3 class="info_text">Gardening is a rewarding and therapeutic hobby that involves cultivating and nurturing plants. Whether you're a beginner or an experienced gardener, understanding the basics is essential for a successful and enjoyable gardening experience. Here are some fundamental points to keep in mind:</h3>
            </div>
            <div class="list">
                <ul>
                    <li>Location and Sunlight</li>
                    <li>Soil Preparation</li>
                    <li>Plant Selection</li>
                    <li>Watering</li>
                    <li>Mulching</li>
                    <li>Pruning and Deadheading</li>
                    <li>Fertilization</li>
                    <li>Pest and Disease Management</li>
                    <li>Spacing</li>
                    <li>Seasonal Care</li>
                    <li>Tools and Equipment</li>
                    <li>Patience and Observation</li>
                </ul>
                <img src="plant1.png" alt="" class="disp_img1">
                <img src="plant2.jpg" alt="" class="disp_img1">
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
        const product = button.getAttribute('data-product');
        const price = parseFloat(button.getAttribute('data-price'));

        const existingCartItem = cartItems.find(item => item.product === product);
        if (existingCartItem) {
          existingCartItem.quantity++;
        } else {
          cartItems.push({ product, price, quantity: 1 });
        }
        cartTotal += price;

        updateCart();
      });
    });

    openCartButton.addEventListener('click', () => {
      slideCart.style.right = '0';
    });

    closeCartButton.addEventListener('click', () => {
      slideCart.style.right = '-300px';
    });

    clearCartButton.addEventListener('click', () => {
      cartItems = [];
      cartTotal = 0;
      updateCart();
    });

    function updateCart() {
      cartItemsElement.innerHTML = '';
      cartTotalElement.textContent = '$' + cartTotal.toFixed(2);

      cartItems.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.product} - $${item.price.toFixed(2)} x ${item.quantity}`;

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