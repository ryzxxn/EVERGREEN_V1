<div class='profile_container'>
    <div class='info_container'>
        <h3>Personal Details</h3>
        <p><?php echo $_SESSION["current_firstname"] . ' ' . $_SESSION["current_lastname"]; ?></p>
        <p><?php echo $_SESSION["current_email"] ?></p>
    </div>
        
    <div class='info_container'>
        <h3>Shipping Details</h3>
        <p><?php echo $_SESSION["current_address"] ?></p>
    </div>
</div>