<?php

    if(!$main -> checkLogin())
    $main -> redirect('../login-recoverey/login.php?msg=access-denied');

    if($main -> safeGet('logout') === '1'){

        $main -> logout();
        $main -> redirect('../login-recoverey/login.php?msg=logout');

    }

?>