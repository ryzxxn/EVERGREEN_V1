<?php
session_start();
error_reporting(0);

if (isset($_POST['reset_button'])) {
    // Reset all session variables
    session_unset();

    $_SESSION['current_uuid'] = null;
    $_SESSION['current_firstname'] = null;
    // Optionally, you may want to destroy the entire session
    // session_destroy();
}
?>
<div class='navbar'>
            <div class='navbar_top'>
                <div class='navbar_left'>
                    <a href='/'>
                    <img
                    class='logo'
                        src="../Assets/evergreen.svg"
                        alt="Picture of the author"
                    />
                    </a>
                </div>
    
                <div class='navbar_right'>
                    <div class="dropdown">
                        <p>Menu</p>
                            <div class="dropdown-content">
                                <a class='page_link' href="../Profile/profile.php">Profile</a>
                                <a class='page_link' href="../Signup/signup.php">Signup</a>
                                <form method="post">
                                <input class='page_link' type="submit" name="reset_button" value="logout">
                                </form>
                            </div>
                    </div>
                    <p><?php echo $_SESSION["current_firstname"] ?></p>
                    <a href='../Cart/cart.php'>
                    Cart
                    </a>
                </div>
            </div>
            <div class='navbar_bottom'>
                        <div class='page_bar'>
                            <a href='/' class='page_link'>HOME</a>
                            <a href='../Shop/shop.php' class='page_link'>SHOP</a>
                            <a href='../Blog/blog.php' class='page_link'>BLOG</a>
                            <a href='../About/about.php' class='page_link'>ABOUT</a>
                            <a href='/contact' class='page_link'>CONTACT</a>
                        </div>
            </div>
        </div>