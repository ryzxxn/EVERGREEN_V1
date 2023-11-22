<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta class="description" content="">
        <meta class="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../global.css">
    </head>
    <body>
    <?php
        require '../Components/navbar.php';

        if (!isset($_SESSION['current_uuid'])) {
            // Redirect to a certain PHP page
            header("Location: /index.php");
            exit(); // Ensure that no further code is executed after the redirect
        }
    ?>

    <?php
        require '../Components/personal_info.php';
    ?>

    <?php
        require '../Components/quickaccess.php';
    ?>
    </body>
</html>