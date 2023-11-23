<div class='quickaccess_parent'>
    <h3 id='h31'>Quick Access</h3>
    <div class='quickaccess_container'> 
        <a href='../Profile/profile.php'><p class='qa_link'>Back</p></a>
        <a href='../Postblog/postblog.php'><p class='qa_link'>Post Blog</p></a>
        <a href='../Myblogs/myblogs.php'><p class='qa_link'>My Blogs</p></a>
        
        <?php
        // Check if $_SESSION['current_verified'] is 1 (assuming it's using 1 for true)
        if (isset($_SESSION["current_verified"]) && $_SESSION["current_verified"] == 1) {
            echo '<a href="../Postlisting/postlisting.php"><p class="qa_link">Post Listing</p></a>';
        }
        ?>
        
        <a href='../Orders/orders.php'><p class='qa_link'>Orders</p></a>

        <?php
        // Check if $_SESSION['current_verified'] is 1 (assuming it's using 1 for true)
        if (isset($_SESSION["current_role"]) && $_SESSION["current_role"] == 'Admin') {
            echo '<a href="../Admin/admin.php"><p class="qa_link">Admin panel</p></a>';
        }
        ?>
    </div>
</div>
