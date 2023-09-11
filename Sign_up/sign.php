<html>
    <head><title>The Evergreen home page</title></head>
<link rel="stylesheet" href="HomeStyle.css">
<body>

    

<video autoplay loop muted plays-inline class="back_video">
    <source src="Evergreen_SignUP_ELEMENTS/sign_up_video.mp4" type="video/mp4">
</video><br>

<div class = "SIGN-UP_form">
    <img src="Evergreen_SignUP_ELEMENTS/evergreen logo.png">

    <br> <h1>SIGN-UP</h1>

    <form method="POST" action="sign.php">
        
        <input name="email_php" type="email" class="InputEmail" placeholder="Enter Email">
        <input name="password_php" type="password" class="InputPassword" placeholder="Enter Password"><br>
        <input type="checkbox"><span>I agree to the terms of services</span></br>
            <button type="submit" class="Sign-btn">LOG-IN</button>
        
        <hr>
        <p class="or">OR</p>
        <button type="button" class="Sign-btn">SIGN-IN</button>
    
    </form>
</div>
    <?php
        session_start();

        if (isset($_SESSION['signInSuccess']) && $_SESSION['signInSuccess']) {
            echo '<p>Sign-in was successful! You can now see this special message.</p>';
            // Reset the session variable
            $_SESSION['signInSuccess'] = false;
        }

        error_reporting(0);
        ini_set('display_errors', 0);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "plant_store";

        $conn = new mysqli($servername, $username, $password, $dbname);

        $password = base64_encode($_POST['password_php']);
        $email = $_POST['email_php'];
        //echo $password;

        $sql = "SELECT user_id FROM customer WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        //print_r($result);

        if ($result->num_rows > 0) {
            // Valid credentials
            echo "Login successful!";
            $signInSuccessful = true; // Replace with your actual sign-in logic

            if ($signInSuccessful) {
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $email; // Replace with the actual username
                $redirectUrl = "../Home_page/index.php";
                header("Location: $redirectUrl");
                exit();
            }
            // You can proceed to set sessions/cookies for the user
        } else {
            // Invalid credentials
            //echo "Invalid email or password.";
        }
    ?>

        
    </body>
</html>