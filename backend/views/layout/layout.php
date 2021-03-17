<?php

    require_once '../../../init.php';

    if(!$main -> checkLogin())
        $main -> redirect('../login-recoverey/login.php?msg=access-denied');

?>