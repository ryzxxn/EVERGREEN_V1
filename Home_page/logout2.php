<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <?php
            session_start();
            $_SESSION['loggedIn'] = false;
            $_SESSION['username'] = NULL;
            session_destroy();
            header("Location: ../Sale_page/sale.php");
            die();
        ?>
    </body>
</html>