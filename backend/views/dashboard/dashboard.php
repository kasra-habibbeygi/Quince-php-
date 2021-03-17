<?php

    require_once '../../../init.php';

    if(!$main -> checkLogin())
        $main -> redirect('../login-recoverey/login.php?msg=access-denied');

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quince Login</title>
    </head>

    <body>

    

    </body>

</html>